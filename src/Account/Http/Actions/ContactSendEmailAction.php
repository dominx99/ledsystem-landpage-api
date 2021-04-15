<?php

declare(strict_types = 1);

namespace App\Account\Http\Actions;

use App\Shared\Domain\Exception\BusinessException;
use App\Shared\Domain\Validation\Validator;
use Psr\Http\Message\ResponseInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Shared\Http\Responses\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;

final class ContactSendEmailAction
{
    public function __construct (
        private Validator $validator,
    ) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody() ?? [];

        $this->validator->validate($body, [
            'sender'  => v::notEmpty()->email(),
            'subject' => v::notEmpty(),
            'body'    => v::notEmpty(),
        ]);

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = env('EMAIL_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('EMAIL_USER');
            $mail->Password   = env('EMAIL_PASS');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom(env('EMAIL_USER'));
            $mail->addAddress(env('CONTACT_EMAIL_TO'));
            $mail->addReplyTo($body['sender']);

            if (env('CONTACT_EMAIL_CC')) {
                $mail->addCC(env('CONTACT_EMAIL_CC'));
            }

            if (env('CONTACT_EMAIL_BCC')) {
                $mail->addBCC(env('CONTACT_EMAIL_BCC'));
            }

            $mail->isHTML(false);
            $mail->Subject = $body['subject'];
            $mail->Body    = $body['body'];

            $mail->send();

            return JsonResponse::create(['status' => 'success']);
        } catch (Exception) {
            return JsonResponse::create(['status' => 'fail']);
            throw new BusinessException('Could not send email');
        }
    }
}
