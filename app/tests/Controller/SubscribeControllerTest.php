<?php

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;
use Modules\Auth\Test\Functional\Json;
use Symfony\Component\HttpFoundation\Response;

class SubscribeControllerTest extends AbstractControllerTest
{
    public function testSubscribe(): void
    {
        $content = json_encode(['email' => 'test@test.com', 'agreed' => true]);
        $this->client->request('POST', '/api/v1/subscribe', [], [], [], $content);

        self::assertResponseIsSuccessful();
    }

    public function testSubscribeNotAgreed(): void
    {
        $content = json_encode(['email' => 'test@test.com']);
        $this->client->request('POST', '/api/v1/subscribe', [], [], [], $content);
        $responseContent = Json::decode($this->client->getResponse()->getContent());

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        self::assertJsonDocumentMatches($responseContent, [
            '$.message' => 'validation failed',
            '$.details.violations' => self::countOf(1),
            '$.details.violations.[0].field' => 'agreed',
        ]);
    }
}
