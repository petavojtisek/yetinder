<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\String\u;

final class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly SluggerInterface $slugger
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadPosts($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $roles,$gender]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setGender($gender);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }



    private function loadPosts(ObjectManager $manager): void
    {
        foreach ($this->getPostData() as [$title, $slug,  $content, $publishedAt, $author,  $name, $gender, $width, $weight, $street, $city, $zip, $country]) {

            $post = new Post();
            $post->setTitle($title);
            $post->setSlug($slug);
            $post->setContent($content);
            $post->setPublishedAt($publishedAt);
            $post->setAuthor($author);
            $post->setName($name);
            $post->setGender($gender);
            $post->setWidth($width);
            $post->setWeight($weight);
            $post->setStreet($street);
            $post->setCity($city);
            $post->setzip($zip);
            $post->setCountry($country);

            $image =  $gender.rand(1,5).'.jpg';
            $post->setImage($image);


            foreach (range(1, 5) as $i) {
                /** @var User $commentAuthor */
                $commentAuthor = $this->getReference('john_user');
                $points = random_int(1,5);
                $comment = new Comment();
                $comment->setAuthor($commentAuthor);
                $comment->setPoints($points);
                $comment->setPublishedAt(new \DateTime('now + '.$i.'seconds'));
                $post->addComment($comment);
                $post->increasePoints($points);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * @return array<array{string, string, string, string, array<string>}>
     */
    private function getUserData(): array
    {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles, $gender];
            ['John Doe', 'john_user', 'kitten', 'john_user@symfony.com', [User::ROLE_USER],'M'],
            ['Petr V', 'petr', 'petrpetr', 'petr@symfony.com', [User::ROLE_USER],'M'],
            ['Katina Mccall', 'katina', 'mccall', 'Katina@symfony.com', [User::ROLE_USER],'F'],
            ['Phillip Beltran', 'phillip', 'beltran', 'Phillip@symfony.com', [User::ROLE_USER],'M'],
            ['Millie Stephenson', 'millie', 'stephenson', 'Millie@symfony.com', [User::ROLE_USER], 'F'],
            ['Lenny Kerr', 'lenny', 'kerr', 'Lenny@symfony.com', [User::ROLE_USER], 'M'],
            ['Edison Lyons', 'edison', 'lyons', 'Edison@symfony.com', [User::ROLE_USER], 'F'],
            ['Cathryn Benitez', 'cathryn', 'benitez', 'Cathryn@symfony.com', [User::ROLE_USER],'F'],
            ['Ladonna Morrison', 'ladonna', 'morrison', 'Ladonna@symfony.com', [User::ROLE_USER], 'F'],
            ['Julianne Merritt', 'julianne', 'merritt', 'Julianne@symfony.com', [User::ROLE_USER],'J'],
            ['Oswaldo Lowe', 'oswaldo', 'lowe', 'Oswaldo@symfony.com', [User::ROLE_USER],'M'],
            ['Josef Randall', 'josef', 'randall', 'Josef@symfony.com', [User::ROLE_USER],'M'],
        ];
    }

    /**
     * @throws \Exception
     *
     * @return array<int, array{0: string, 1: AbstractUnicodeString, 2: string, 3: string, 4: \DateTime, 5: User, 6: array<Tag>}>
     */
    private function getPostData(): array
    {
        $posts = [];
        $users = $this->getUserData();
        foreach ($this->getNames() as $i => $nameData) {
            // $postData = [$title, $slug,  $content, $publishedAt, $author,  $name, $gender, $width, $weight, $street, $city, $zip, $country];

            /** @var User $user */
           // ['john_user', 'petr'][0 === $i ? 0 : random_int(0, 1)]
            $userSearchKey = random_int(1, (count($users)-1));
            $user = $this->getReference($users[$userSearchKey][1]);
            $gender = $nameData['gender'];
            $title = $this->getTitle($gender);

            $country =  ($i<2)? 'PL' : 'CZ';


            $posts[] = [
                $title,
                $this->slugger->slug($nameData['name'])->lower(),
                $this->getPostContent($gender),
                (new \DateTime('now - '.$i.'days'))->setTime(random_int(8, 17), random_int(7, 49), random_int(0, 59)),
                // Ensure that the first post is written by Jane Doe to simplify tests
                $user,
                $nameData['name'],
                $gender,
                (random_int(220, 420)),
                (random_int(220, 820)),
                $this->getRandomStreet(),
                $this->getRandomCity(),
                $this->getRandomZip(),
                $country
            ];
        }

        return $posts;
    }


    private function getNames(){
        return [
                ['name'=>"Yarik", "gender"=>"M"],
                ['name'=>"Kaltok", "gender"=>"M"],
                ['name'=>"Thagor", "gender"=>"M"],
                ['name'=>"Borvok", "gender"=>"M"],
                ['name'=>"Gorvoth", "gender"=>"M"],

            ['name'=>"Luminia", "gender"=>"F"],
            ['name'=>"Avalyn", "gender"=>"F"],
            ['name'=>"Nevira", "gender"=>"F"],
            ['name'=>"Kalindi", "gender"=>"F"],
            ['name'=>"Vedrana", "gender"=>"F"],

        ];
    }

    private function getTitle($gender){
        $title['M'][]="Král Yeti";
        $title['M'][]="Lovec Yeti";
        $title['M'][]="Sněžný Hrdina";
        $title['M'][]="Ledový Vládce";
        $title['M'][]="Jakub z Himalájí";


        $title['F'][]="Sněžná Princezna";
        $title['F'][]="Ledová Drakona";
        $title['F'][]="Údolní Mágyně";
        $title['F'][]="Horská Rusalka";
        $title['F'][]="Tajemná Sněhule";

        $key = random_int(0, (count($title[$gender])-1));
        return $title[$gender][$key];

    }

    private function getRandomStreet(){
        $street = [
            "Dělnická 194/2",
            "Roztoky u Jilemnice 395",
            "Holubice 381",
            "Zámecká 49",
            "Lesní 1290",
            "Pod pekárnami 19/104",
            "Štúrova 1701/55",
            "Porhajmova 13",
            "werichova 2007/2",
            "Nedašov 411",
            "Podoli 300",
            "Družstevní 76",
            "Zdislavice 107",
            "Čtvercova 866",
            "Krňany 73",
            "Děčínská 310",
            "Tichá 413",
            "Blachutova 930/2",
            "Kotrčova 615",
            "Jiráskova 283",
            "Nad Špejcharem 130",
            "Zimákova 832/12",
            "Lesní 736",
            "Černovice 76",
            "kaznějovská 54",
            "Kpt.Jaroše 641/5",
            "Skupova 6",
            "Střední 9",
            "Petrovice 31",
            "Masarykova 406",
            "sazavska, 1",
            "zahradni, 5186",
            "Plzeňská 233",
            "S. K. Neumanna 989",
            "Ponětovická 8",
            "Jevišovická 228/14",
            "Jevišovická 228/14",
            "Jevišovická 228/14",
            "Zeyerova 12",
            "Na Louži 3",
        ];

        $key = random_int(0, 38);
        return $street[$key];
    }
    private function getRandomCity(){
        $city = [
                   "Praha",
                   "Roztoky u Jilemnice",
                   "Holubice",
                   "Rosice u Brna",
                   "Frýdlant",
                   "Brno",
                   "Nedašov",
                   "Podoli",
                   "Chuchelná",
                   "Zdounky",
                   "Neratovice",
                   "Netvořice",
                   "Žandov",
                   "Tichá",
                   "Praha 9",
                   "Hradec Králové",
                   "Zlín",
                   "Radim",
                   "Praha",
                   "Náměšť nad Oslavou",
                   "Černovice",
                   "Plzeň",
                   "Třebíč",
                   "Plzen",
                   "Brno",
                   "Týniště nad Orlicí",
                   "Korycany",
                   "praha",
                   "Chomutov",
                   "Jesenice okr. Rakovník",
                   "Doksy",
                   "Brno",
                   "Znojmo",
                   "Olomouc",
                   "Ústí nad Labem",
        ];

        $key = random_int(0, 32);
        return $city[$key];

    }
    private function getRandomZip(){
        $zip= [
            17000,
            51231,
            68351,
            66501,
            46401,
            19000,
            14000,
            61800,
            41201,
            76332,
            66403,
            74724,
            76802,
            27711,
            25744,
            47107,
            74274,
            19600,
            50703,
            76001,
            28103,
            14900,
            67571,
            67975,
            32300,
            67401,
            30100,
            60200,
            51721,
            76805,
            12000,
            43004,
            27033,
            47201
            ];

        $key = random_int(0, 31);
        return $zip[$key];
    }



    private function getPostContent($gender): string
    {

        $content['M'][]="Silný ochránce hor s mocným duchem";
        $content['M'][]="Tajemný tvor, co se skrývá ve stínu.";
        $content['M'][]="Nebojácný hrdina, co brání své území.";
        $content['M'][]="Chladný a mazaný, vždy ve střehu.";
        $content['M'][]="Zvídavý yeti, který rád objevuje.";


        $content['F'][]="Královna sněhu s elegancí a grácií.";
        $content['F'][]="Silná bojovnice, co chrání svá tajemství.";
        $content['F'][]="Moudrá mágyně, co rozumí přírodě.";
        $content['F'][]="Fascinující rusalka, co okouzlí každého.";
        $content['F'][]="Záhadná sněhule, co se zjevuje v noci.";

        $key = random_int(0, (count($content[$gender])-1));
        return $content[$gender][$key];

    }


}
