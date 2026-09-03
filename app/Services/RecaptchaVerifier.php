<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaVerifier
{
    protected string $secretKey;
    protected float $minScore;

    public function __construct()
    {
        $this->secretKey = config('services.recaptcha.secret_key');
        $this->minScore = (float) config('services.recaptcha.min_score', 0.5);
    }

    /**
     * @param string|null $token
     * @param string $expectedAction  e.g. 'contact_submit', 'quote_submit', 'career_submit'
     */
    public function verify(?string $token, string $expectedAction): bool
    {
        if (empty($token)) {
            return false;
        }

        if (empty($this->secretKey)) {
            // لو المفاتيح مش متظبطة، نمنع فشل السيرفر بالكامل بس نسجل تحذير
            Log::warning('reCAPTCHA secret key is not configured.');
            return true;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $this->secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (! ($result['success'] ?? false)) {
                Log::info('reCAPTCHA failed', ['errors' => $result['error-codes'] ?? []]);
                return false;
            }

            if (($result['action'] ?? null) !== $expectedAction) {
                Log::info('reCAPTCHA action mismatch', [
                    'expected' => $expectedAction,
                    'got' => $result['action'] ?? null,
                ]);
                return false;
            }

            $score = (float) ($result['score'] ?? 0);

            if ($score < $this->minScore) {
                Log::info('reCAPTCHA low score', ['score' => $score]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA verification error: ' . $e->getMessage());
            // فشل الاتصال بجوجل نفسه مش لازم يوقف المستخدم الشرعي
            return true;
        }
    }
}