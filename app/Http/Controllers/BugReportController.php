<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BugReportController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'page_url' => 'nullable|url',
            'user_agent' => 'nullable|string',
            'source' => 'required|in:landing,admin',
        ];

        if (config('services.turnstile.enabled')) {
            $rules['cf-turnstile-response'] = 'required|string';
        }

        $validator = Validator::make($request->all(), $rules, [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Por favor, insira um e-mail válido.',
            'subject.required' => 'O assunto é obrigatório.',
            'description.required' => 'A descrição é obrigatória.',
            'description.min' => 'A descrição deve ter pelo menos 10 caracteres.',
            'source.required' => 'A origem do relatório é obrigatória.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if (config('services.turnstile.enabled')) {
                $client = new \GuzzleHttp\Client(['timeout' => 5]);
                $response = $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'form_params' => [
                        'secret' => config('services.turnstile.secret_key'),
                        'response' => $request->input('cf-turnstile-response'),
                        'remoteip' => $request->ip(),
                    ]
                ]);
                $body = json_decode((string) $response->getBody(), true);
                if (!($body['success'] ?? false)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Falha na verificação antispam.'
                    ], 422);
                }
            }
            // Dados do relatório
            $bugData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'description' => $request->description,
                'page_url' => $request->page_url ?? 'Não informado',
                'user_agent' => $request->user_agent ?? 'Não informado',
                'source' => $request->source,
                'timestamp' => now()->format('d/m/Y H:i:s'),
                'ip_address' => $request->ip()
            ];

            // Enviar e-mail para suporte (usar o mesmo e-mail configurado no .env)
            $supportEmail = config('mail.from.address');
            Mail::send('emails.bug-report', $bugData, function ($message) use ($bugData, $supportEmail) {
                $message->to($supportEmail)
                        ->subject('[BUG REPORT] ' . $bugData['subject'])
                        ->replyTo($bugData['email'], $bugData['name']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Relatório enviado com sucesso! Nossa equipe analisará e retornará em breve.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro ao enviar relatório de bug: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar relatório. Tente novamente ou entre em contato diretamente.'
            ], 500);
        }
    }
}
