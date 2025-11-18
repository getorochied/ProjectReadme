<?php

namespace App\Tests\Controller;

use App\Entity\Showcase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ShowcaseControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $showcaseRepository;
    private string $path = '/showcase/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->showcaseRepository = $this->manager->getRepository(Showcase::class);

        foreach ($this->showcaseRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Showcase index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'showcase[title]' => 'Testing',
            'showcase[description]' => 'Testing',
            'showcase[isPublic]' => 'Testing',
            'showcase[owner]' => 'Testing',
            'showcase[projects]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->showcaseRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Showcase();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setIsPublic('My Title');
        $fixture->setOwner('My Title');
        $fixture->setProjects('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Showcase');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Showcase();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setIsPublic('Value');
        $fixture->setOwner('Value');
        $fixture->setProjects('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'showcase[title]' => 'Something New',
            'showcase[description]' => 'Something New',
            'showcase[isPublic]' => 'Something New',
            'showcase[owner]' => 'Something New',
            'showcase[projects]' => 'Something New',
        ]);

        self::assertResponseRedirects('/showcase/');

        $fixture = $this->showcaseRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getIsPublic());
        self::assertSame('Something New', $fixture[0]->getOwner());
        self::assertSame('Something New', $fixture[0]->getProjects());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Showcase();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setIsPublic('Value');
        $fixture->setOwner('Value');
        $fixture->setProjects('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/showcase/');
        self::assertSame(0, $this->showcaseRepository->count([]));
    }
}
