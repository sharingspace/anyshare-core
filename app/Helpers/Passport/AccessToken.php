<?php
namespace App\Helpers\Passport;

use Laravel\Passport\Bridge\AccessToken as PassportAccessToken;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\OAuth2\Server\CryptKey;
use Illuminate\Http\Request;
use App\Models\oAuthClient;

class AccessToken extends PassportAccessToken {

    public function convertToJWT(CryptKey $privateKey)
    {

        return (new Builder())
            ->setAudience($this->getClient()->getIdentifier())
            ->setId($this->getIdentifier(), true)
            ->setIssuedAt(time())
            ->setNotBefore(time())
            ->setExpiration($this->getExpiryDateTime()->getTimestamp())
            ->setSubject($this->getUserIdentifier())
            ->set('scopes', $this->getScopes())
            ->set('community', $this->getCommunity()) // my custom claims
            ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
            ->getToken();
    }

    // my custom claims for roles
    // Just an example.
    public function getCommunity() {
        $request = oAuthClient::find($this->getClient()->getIdentifier())->community_apis->first()->id;

        return [
            'id' => $request,
        ];
    }
}