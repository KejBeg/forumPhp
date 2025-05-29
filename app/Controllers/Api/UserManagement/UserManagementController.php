<?php
require_once API . '/BaseController.php';

class UserManagementController extends BaseController
{

    public ?array $jwtArray = null;

    /**
     * Checks the gender
     *
     * Checks whether the gender is valid or not.
     * If it isn't, it sets the gender to "male" by default.
     * If unsuccessful, the user recevies a response with an error message.
     * And the script exits.
     **/
    public function checkGender()
    {
        if (!in_array($this->requestJson['gender'], GENDERS)) {
            $this->requestJson['gender'] = GENDERS[0];
        }
    }

    /**
     * Checks the email
     *
     * Checks whether the email format is valid or not.
     * If it isn't, the user receives a response with an error message.
     * And the script exits.
     **/
    public function checkMail()
    {
        if (!filter_var($this->requestJson['email'], FILTER_VALIDATE_EMAIL)) {
            $this->responseHandler->incorrectMailFormat();
            exit;
        }
    }

    /**
     * Checks the username
     *
     * Checks whether the username format is valid or not.
     * If it isn't, the user receives a response with an error message.
     * And the script exits.
     **/
    public function checkUsername()
    {
        if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $this->requestJson['name'])) {
            $this->responseHandler->incorrectUsernameFormat();
            exit;
        }
    }

    /**
     * Checks the password
     *
     * Checks whether the password format is valid or not.
     * If it isn't, the user receives a response with an error message.
     * And the script exits.
     **/
    public function checkPassword()
    {
        if (!preg_match('/^[a-zA-Z0-9_!@#$%^&*()\-]{8,}$/', $this->requestJson['pass'])) {
            $this->responseHandler->incorrectPasswordFormat();
            exit;
        }
    }

    public function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64UrlDecode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padLen = 4 - $remainder;
            $input .= str_repeat('=', $padLen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }


    public function generateJwt(int $userId): string
    {
        include_once MODELS . '/UserModel.php';
        $userModel = new User();
        $user = $userModel->getUser($userId);
        if (!$user) {
            $this->responseHandler->userNotFound();
            exit;
        }

        $header = JWT_HEADER;

        $payload = [
        'sub' => $user['id'],
        'name' => $user['username'],
        'iat' => time(),
        'exp' => time() + 900
        ];

        $encodedHeader = $this->base64url_encode(json_encode($header));
        $encodedPayload = $this->base64url_encode(json_encode($payload));

        $signature = hash_hmac('sha256', "$encodedHeader.$encodedPayload",JWT_SECRET, true);
        $encodedSignature = $this->base64url_encode($signature);

        $jwt = "$encodedHeader.$encodedPayload.$encodedSignature";
        return $jwt;
    }

    public function deconstructJwt(string $jwt): void
    {
        $parts = explode('.', $jwt);

        $header = json_decode($this->base64UrlDecode($parts[0]), true);
        $payload = json_decode($this->base64UrlDecode($parts[1]), true);

        $signature = $this->base64UrlDecode($parts[2]);

        $expectedSignature = hash_hmac('sha256', "$parts[0].$parts[1]", JWT_SECRET, true);



        $this->jwtArray = (array) [
        'header' => $header,
        'payload' => $payload,
        'signature' => $signature,
        'expectedSignature' => $expectedSignature
        ];
    }

    public function setAccessToken(int $userId): void
    {
        $jwt = $this->generateJwt($userId);
        setcookie(
            'access_token',
            $jwt,
            [
            'expires' => time() + 900,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
            ]
        );
    }

    public function checkAccessToken(): bool
    {
        if (isset($this->accessToken)) {
            $this->deconstructJwt($this->accessToken);

            if ($this->jwtArray['signature'] !== $this->jwtArray['expectedSignature']) {
                $this->logger->log('Invalid JWT signature');
                return false;
            }
            if ($this->jwtArray['header']['alg'] !== JWT_HEADER['alg']) {
                $this->logger->log('Invalid JWT algorithm');
                return false;
            }

            if ($this->jwtArray['header']['typ'] !== JWT_HEADER['typ']) {
                $this->logger->log('Invalid JWT type');
                return false;
            }

            if ($this->jwtArray['payload']['exp'] < time()) {
                $this->logger->log('JWT expired');
                return false;
            }
            $this->logger->log('JWT is valid');
            return true;
        }
        $this->logger->log('No JWT provided');
        return false;
    }
}
