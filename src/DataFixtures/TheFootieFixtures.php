<?php

namespace App\DataFixtures;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TheFootieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Add a few Leagues so our app starts with basic
        // data to show the list at least.

        //  League.
        $league = new League();
        $league->setName('Premier League');
        $manager->persist($league);

        // Add another league.
        $league = new League();
        $league->setName('Sunshine League');
        $manager->persist($league);

        // Add Team
        $team = new Team();
        $team->setName('Team1');
        $team->setStrip('Red striped shirts, white shorts');
        $manager->persist($team);

        // Add another team.
        $team = new Team();
        $team->setName('Team2');
        $team->setStrip('Red shirts, red shorts');
        $manager->persist($team);

        //Write to disk.
        $manager->flush();
    }
}
