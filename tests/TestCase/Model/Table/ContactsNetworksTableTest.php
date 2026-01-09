<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactsNetworksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactsNetworksTable Test Case
 */
class ContactsNetworksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactsNetworksTable
     */
    protected $ContactsNetworks;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ContactsNetworks',
        'app.Contacts',
        'app.Networks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ContactsNetworks') ? [] : ['className' => ContactsNetworksTable::class];
        $this->ContactsNetworks = $this->getTableLocator()->get('ContactsNetworks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactsNetworks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ContactsNetworksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ContactsNetworksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
