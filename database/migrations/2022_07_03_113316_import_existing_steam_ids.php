<?php

use App\User;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * This is horribly inefficient but works...
         */
        User::without('notes')->where('playerID', null)->chunk(20, function ($users) {
            /** @var User $user */
            foreach ($users as $user) {
                foreach (self::EXISTING_SQUAD_USERS as $playerID => $squad_user) {
                    if (strtolower($user->username) === strtolower($squad_user['name']) || strtolower($user->username) === strtolower($squad_user['nick'])) {
                        $user->update([
                            'playerID' => $playerID,
                            'remark' => $squad_user['remark'],
                            'shortName' => $squad_user['nick'],
                        ]);
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /**
         * This is horribly inefficient but works...
         */
        User::without('notes')->chunk(20, function ($users) {
            /** @var User $user */
            foreach ($users as $user) {
                foreach (self::EXISTING_SQUAD_USERS as $playerID => $squad_user) {
                    if (strtolower($user->username) === strtolower($squad_user['name']) || strtolower($user->username) === strtolower($squad_user['nick'])) {
                        $user->update([
                            'playerID' => null,
                            'remark' => null,
                            'shortName' => null,
                        ]);
                    }
                }
            }
        });
    }

    public const EXISTING_SQUAD_USERS = [
        "76561198000746503" => [
            "nick" => "Monty",
            "name" => "Monty",
            "remark" => "Noble Three"
        ],
        "76561197994625073" => [
            "nick" => "Aliasalpha",
            "name" => "Aliasalpha",
            "remark" => "I know no fear for I am fear incarnate!"
        ],
        "76561197979238882" => [
            "nick" => "Lightning",
            "name" => "Lightning",
            "remark" => "Hold my beer, Watch this!"
        ],
        "76561198081499095" => [
            "nick" => "Wee",
            "name" => "Wee",
            "remark" => "We have ditched RHS!!!"
        ],
        "76561198032751791" => [
            "nick" => "Rajiin Terra",
            "name" => "Rajiin Terra",
            "remark" => "Paid in booze"
        ],
        "76561198341117286" => [
            "nick" => "Hulksey",
            "name" => "Hulksey",
            "remark" => "Only works 80% of the time all the time."
        ],
        "76561198011857510" => [
            "nick" => "Lachy",
            "name" => "Lachy",
            "remark" => "No good formation survives first contact with a forest"
        ],
        "76561198042003815" => [
            "nick" => "Thane",
            "name" => "Thane",
            "remark" => "Who keeps letting me drive?"
        ],
        "76561198074246065" => [
            "nick" => "Jakew100",
            "name" => "Jakew100",
            "remark" => "If in doubt, Monty it out!"
        ],
        "76561198053695749" => [
            "nick" => "Furnace",
            "name" => "Furnace",
            "remark" => "Have you got any blood?"
        ],
        "76561198079007629" => [
            "nick" => "Princess Andromeda",
            "name" => "Princess Andromeda",
            "remark" => "What do you mean I can't have the callsign PixieDust!"
        ],
        "76561198025883065" => [
            "nick" => "Kryen",
            "name" => "Kryen",
            "remark" => "There's an R before the Y"
        ],
        "76561198028386566" => [
            "nick" => "Jumunji",
            "name" => "Jumunji",
            "remark" => "N/A"
        ],
        "76561197991853377" => [
            "nick" => "Cryptic",
            "name" => "Cryptic",
            "remark" => "What is the music of Life... Silence my brother."
        ],
        "76561198015275473" => [
            "nick" => "Ryan",
            "name" => "Ryan",
            "remark" => "Drive me closer, i want to hit them with my sword."
        ],
        "76561198119400346" => [
            "nick" => "Stuba",
            "name" => "Stuba",
            "remark" => "Any dog under 50 pounds is a cat, and cats are useless."
        ],
        "76561197997296998" => [
            "nick" => "BlackIrishGuy",
            "name" => "BlackIrishGuy",
            "remark" => "Callsign: Sabre Actual"
        ],
        "76561198167523480" => [
            "nick" => "Crusier",
            "name" => "Crusier",
            "remark" => "N/A"
        ],
        "76561198089619681" => [
            "nick" => "Kirky",
            "name" => "Kirky",
            "remark" => "Pineapple belongs on pizza"
        ],
        "76561198214951939" => [
            "nick" => "Ian",
            "name" => "Ian",
            "remark" => "Likes noodles and anime"
        ],
        "76561198023820632" => [
            "nick" => "CombatWombats",
            "name" => "CombatWombats",
            "remark" => "Jimbob"
        ],
        "76561198163811542" => [
            "nick" => "Amatus",
            "name" => "Amatus",
            "remark" => "Inshallah"
        ],
        "76561198045423290" => [
            "nick" => "Kaspa",
            "name" => "Kaspa",
            "remark" => "Let us just pretend that I wrote something clever here.."
        ],
        "76561198360768152" => [
            "nick" => "wilson",
            "name" => "wilson",
            "remark" => "can not have grenades"
        ],
        "76561197970825453" => [
            "nick" => "Wasp",
            "name" => "Wasp",
            "remark" => "Falls asleep without notice"
        ],
        "76561198137572450" => [
            "nick" => "TheLJFox",
            "name" => "LJFox",
            "remark" => "Hand me a grenade, I'm going to teach spacing"
        ],
        "76561198009594520" => [
            "nick" => "Luigi",
            "name" => "Luigi",
            "remark" => "Luweeeeeeeegi"
        ],
        "76561198135034600" => [
            "nick" => "Mindy",
            "name" => "Mindy",
            "remark" => "You're not my supervisor!"
        ],
        "76561198033896373" => [
            "nick" => "Gurnhawk",
            "name" => "Gurnhawk",
            "remark" => "Don't worry Gurn, one day you'll pass basic."
        ],
        "76561198072917139" => [
            "nick" => "TheRiddler",
            "name" => "TheRiddler",
            "remark" => "Oh, I survived. Brilliant, I love it when I do that"
        ],
        "76561197985731410" => [
            "nick" => "Leno",
            "name" => "Leno",
            "remark" => "N/A"
        ],
        "76561198311056437" => [
            "nick" => "ypk2909",
            "name" => "ypk2909",
            "remark" => "King of pigeons"
        ],
        "76561197977596819" => [
            "nick" => "Bearded_Nate",
            "name" => "Nate",
            "remark" => "Plays the role of bullet sponge well"
        ],
        "76561198027753211" => [
            "nick" => "Puddleflop",
            "name" => "Puddleflop",
            "remark" => "Wait, you want me to go towards the explosions?"
        ],
        "76561197978962083" => [
            "nick" => "Deadpell",
            "name" => "Deadpell",
            "remark" => "frags are not friendly"
        ],
        "76561197986105919" => [
            "nick" => "McCready",
            "name" => "McCready",
            "remark" => "Sierra Charlie"
        ],
        "76561198159240681" => [
            "nick" => "Spyder",
            "name" => "Spyder",
            "remark" => "First In, First Shot"
        ],
        "76561198093944268" => [
            "nick" => "Slaodacht",
            "name" => "Slaodacht",
            "remark" => "What do you mean the middle of the open doesn't count as cover"
        ],
        "76561198452078532" => [
            "nick" => "Wolfie",
            "name" => ".Wolfie",
            "remark" => "Remember rear security? Yeah, that is why you are dead"
        ],
        "76561198058575643" => [
            "nick" => "NotTitan",
            "name" => "NotTitan",
            "remark" => "Wait, what's an M4? WHAT'S AN AK!?"
        ],
        "76561198087111857" => [
            "nick" => "Seal Team Me",
            "name" => "Seal Team Me",
            "remark" => "They are rage, brutal, without mercy. But you. You will be worse. Rip and tear, until it is done"
        ],
        "76561198089817963" => [
            "nick" => "AussieArchAngel",
            "name" => "AussieArchAngel",
            "remark" => "Not my fault, someone put a wall in my way"
        ],
        "76561198089665351" => [
            "nick" => "Derpymcmuffins",
            "name" => "Derpymcmuffins",
            "remark" => "Heyooo"
        ],
        "76561198317906283" => [
            "nick" => "Heffio",
            "name" => "Heffio",
            "remark" => "EXPLOSION!"
        ],
        "76561198007149246" => [
            "nick" => "Strutty",
            "name" => "Strutty",
            "remark" => "Strutting my stuff"
        ],
        "76561198197288931" => [
            "nick" => "razorwork",
            "name" => "razorwork",
            "remark" => "I'm the dude playing the dude disguised as another dude"
        ],
        "76561198017161714" => [
            "nick" => "GetThatCat",
            "name" => "GetThatCat",
            "remark" => "Enjoys head pats"
        ],
        "76561198082884446" => [
            "nick" => "iliketacos",
            "name" => "Tacos",
            "remark" => "Beer tastes like shit, don't at me"
        ],
        "76561198175546305" => [
            "nick" => "Jason",
            "name" => "Jason",
            "remark" => "Damn it, my internet!"
        ],
        "76561198009041092" => [
            "nick" => "Moorgar",
            "name" => "Moorgar",
            "remark" => "my life is suffering, make it worse"
        ],
        "76561198045342235" => [
            "nick" => "Sparky",
            "name" => "Sparky",
            "remark" => "Who?"
        ],
        "76561198029278967" => [
            "nick" => "Mother77",
            "name" => "Mother77",
            "remark" => "Yelled at by mum? maybe you did something stupid"
        ],
        "76561198079220344" => [
            "nick" => "Rileyfitz",
            "name" => "Rileyfitz",
            "remark" => "I guess trying IS the first step to failure"
        ],
        "76561198059261994" => [
            "nick" => "Keegan",
            "name" => "Keegan",
            "remark" => "I have done nothing but teleport bread for 3 days"
        ],
        "76561198036931731" => [
            "nick" => "pokemehard",
            "name" => "pokemehard",
            "remark" => "Don't ask how I got the name"
        ],
        "76561198052510376" => [
            "nick" => "Shadow",
            "name" => "Shadow",
            "remark" => "10 years of not giving a shit about anyone (except Alias who I love)"
        ],
        "76561198824342479" => [
            "nick" => "coonacool",
            "name" => "coonacool",
            "remark" => "Not the racist kind of Coon... but the blind kinda coon"
        ],
        "76561198008930274" => [
            "nick" => "Det0n8ted",
            "name" => "Det0n8ted",
            "remark" => "Pucker up your buttholes, because its about to get loose"
        ],
        "76561198134718546" => [
            "nick" => "Graham",
            "name" => "Graham",
            "remark" => "I just used all of my bandages on a fucking scratch"
        ],
        "76561198087385355" => [
            "nick" => "Jack",
            "name" => "Jack Rogers",
            "remark" => "Never allow me to drive. It always ends in disaster."
        ],
        "76561198278503105" => [
            "nick" => "ausdoz",
            "name" => "AlpackaHacka",
            "remark" => "Well, fan just hit the shit."
        ],
        "76561198417455214" => [
            "nick" => "Eclipse",
            "name" => "dcm",
            "remark" => "There is no geneva convention lads"
        ],
        "76561198019916230" => [
            "nick" => "Fitzypyro",
            "name" => "Fitzypyro",
            "remark" => "What am I doing? I don't even know but its gonna look GREAT."
        ],
        "76561198021103627" => [
            "nick" => "Corny",
            "name" => "Corny",
            "remark" => "Aim towards the Enemy..."
        ],
        "76561198054980917" => [
            "nick" => "[730] Spectre",
            "name" => "Spectre",
            "remark" => "If you're reading this you are a Sierra Charlie. Just fucking download SQUAD already."
        ],
        "76561198032287884" => [
            "nick" => "Wikus",
            "name" => "Wikus",
            "remark" => "Ah, curse your sudden but inevitable betrayal!"
        ],
        "76561198350642419" => [
            "nick" => "Halligan",
            "name" => "Halligan",
            "remark" => "Delusional, Halligan, Hooligan or Steve Hooligan call me whatever the hell you want to call me."
        ],
        "76561198078068020" => [
            "nick" => "Sneaking",
            "name" => "SneakingTurtle",
            "remark" => "I ask the stupid questions."
        ],
        "76561198174885338" => [
            "nick" => "Riceball",
            "name" => "Riceball",
            "remark" => "Edible but not disposable"
        ],
        "76561198017429901" => [
            "nick" => "Joker",
            "name" => "Joker",
            "remark" => "when in doubt grenade out"
        ],
        "76561197982046582" => [
            "nick" => "Bluey",
            "name" => "Bluey",
            "remark" => "How do I get out of this Chickenshit Outfit"
        ],
        "76561198022667781" => [
            "nick" => "Kollokid",
            "name" => "Kollokid",
            "remark" => "Not to be given grenades"
        ],
        "76561198060270224" => [
            "nick" => "Harlow",
            "name" => "Harlow",
            "remark" => "clueless"
        ],
        "76561198129192884" => [
            "nick" => "Vestung",
            "name" => "Vestung",
            "remark" => "did he say fire at will or fire at Will?"
        ],
        "76561198149052333" => [
            "nick" => "Atlas",
            "name" => "Atlas",
            "remark" => "Are we the baddies?"
        ],
        "76561197963705701" => [
            "nick" => "L3ad_Magn3t",
            "name" => "L3ad_Magn3t",
            "remark" => "What?? Speak up, can't hear you over my daka and no I'm not stopping!"
        ],
        "76561198038614629" => [
            "nick" => "Snipe",
            "name" => "N/A",
            "remark" => "Professional Medic"
        ],
        "76561198117709665" => [
            "nick" => "Almond",
            "name" => "N/A",
            "remark" => "noided"
        ],
        "76561198048227977" => [
            "nick" => "Squar2.72",
            "name" => "Squar2.72",
            "remark" => "No, 2:72 is NOT my kill:death ratio"
        ],
        "76561198334818391" => [
            "nick" => "Killbane184",
            "name" => "N/A",
            "remark" => "Shoots stuff in ,and or, around the face"
        ],
        "76561198042270887" => [
            "nick" => "Joel",
            "name" => "N/A",
            "remark" => "Oh dang, the bushes be speakin North Korean again"
        ],
        "76561199076146158" => [
            "nick" => "sultanofdarts",
            "name" => "sultan",
            "remark" => "Sultan's down"
        ],
        "76561198372233864" => [
            "nick" => "BATMAN",
            "name" => "BATMAN",
            "remark" => "What is for lunch "
        ],
        "76561198139620665" => [
            "nick" => "thenb",
            "name" => "thenb",
            "remark" => "I’m keen to play Arma"
        ],
        "76561198008721625" => [
            "nick" => "Arcadian_Angel",
            "name" => "Angel",
            "remark" => "\"Fear is the Mind Killer\""
        ],
        "76561198224793364" => [
            "nick" => "Crevel",
            "name" => "Crevel",
            "remark" => "\"It's easier to do a job right than to explain why you didn't.\""
        ],
        "76561198049912639" => [
            "nick" => "Skit",
            "name" => "Skit",
            "remark" => "\"It's a typo, it's supposed to have a 'h'.\""
        ],
        "76561197997069909" => [
            "nick" => "DasGI",
            "name" => "DasGI",
            "remark" => "\"if I don't know what I'm doing, the enemy doesn't either.\""
        ],
    ];
};
