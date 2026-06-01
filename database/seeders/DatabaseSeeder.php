<?php

namespace Database\Seeders;

use App\Models\CreativeType;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $architecture = CreativeType::updateOrCreate(
            ['slug' => 'arhitekturnoe-modelirovanie'],
            [
                'name' => 'Архитектурное моделирование',
                'description' => 'Архитектурное моделирование — это изготовление моделей зданий, сооружений, исторических памятников, а также инженерных и фортификационных сооружений. Программа формирует эстетический вкус, развивает пространственное мышление и знакомит с народными традициями и базовыми приемами деревообработки. На занятиях участники получают теорию и сразу применяют ее на практике, создавая собственные макеты и реконструкции.',
                'image_path' => 'assets/media/architectural-model-pictures-cool-architectural-model-.jpg',
            ],
        );

        $cooking = CreativeType::updateOrCreate(
            ['slug' => 'kulinariya'],
            [
                'name' => 'Кулинария',
                'description' => 'Кулинария помогает научиться готовить правильно, вкусно и быстро. На мастер-классах участники осваивают современные приемы приготовления, учатся подбирать качественные продукты и создавать блюда, которыми можно порадовать семью и гостей. Направление совмещает практику, культуру питания и атмосферу живого общения.',
                'image_path' => 'assets/media/perfect-porterhouse-steak-940x560.jpg',
            ],
        );

        $wood = CreativeType::updateOrCreate(
            ['slug' => 'rezba-po-derevu'],
            [
                'name' => 'Резьба по дереву',
                'description' => 'Резьба по дереву — один из древнейших видов декоративного искусства. На занятиях участники знакомятся с традициями художественной обработки дерева, учатся работать с орнаментом и создавать собственные композиции. Направление подходит для тех, кто хочет развить усидчивость, аккуратность и творческое мышление.',
                'image_path' => 'assets/media/9.jpg',
            ],
        );

        $leaderOne = User::updateOrCreate(
            ['email' => 'leader1@example.com'],
            [
                'name' => 'Иванова Ольга Ивановна',
                'password' => 'password',
                'phone' => '+7 (900) 111-11-11',
                'role' => User::ROLE_LEADER,
                'photo_path' => 'assets/img/driver1.png',
            ],
        );

        $leaderTwo = User::updateOrCreate(
            ['email' => 'leader2@example.com'],
            [
                'name' => 'Петров Сергей Алексеевич',
                'password' => 'password',
                'phone' => '+7 (900) 222-22-22',
                'role' => User::ROLE_LEADER,
                'photo_path' => 'assets/img/driver2.png',
            ],
        );

        $leaderThree = User::updateOrCreate(
            ['email' => 'leader3@example.com'],
            [
                'name' => 'Соколова Марина Викторовна',
                'password' => 'password',
                'phone' => '+7 (900) 333-33-33',
                'role' => User::ROLE_LEADER,
                'photo_path' => 'assets/img/driver3.png',
            ],
        );

        $visitor = User::updateOrCreate(
            ['email' => 'visitor@example.com'],
            [
                'name' => 'Иванов Иван Иванович',
                'password' => 'password',
                'phone' => '+7 (900) 444-44-44',
                'role' => User::ROLE_VISITOR,
            ],
        );

        $masterClasses = [
            [
                'creative_type_id' => $architecture->id,
                'leader_id' => $leaderOne->id,
                'title' => 'Моделирование моделей транспорта',
                'description' => 'Участники учатся проектировать модели транспортных средств, работать с материалами и собирать устойчивые конструкции.',
                'session_date' => Carbon::today()->addDays(3)->toDateString(),
                'slot_time' => '09:00:00',
                'max_participants' => 8,
                'price' => 1200,
            ],
            [
                'creative_type_id' => $architecture->id,
                'leader_id' => $leaderTwo->id,
                'title' => 'Моделирование зданий и сооружений',
                'description' => 'Практическое занятие по созданию элементов малоэтажных зданий, стен и крыш из простых материалов.',
                'session_date' => Carbon::today()->addDays(5)->toDateString(),
                'slot_time' => '13:00:00',
                'max_participants' => 10,
                'price' => 1500,
            ],
            [
                'creative_type_id' => $cooking->id,
                'leader_id' => $leaderThree->id,
                'title' => 'Шоколадные поделки',
                'description' => 'Создание шоколадных фигурок и праздничных сладостей из качественных ингредиентов.',
                'session_date' => Carbon::today()->addDays(4)->toDateString(),
                'slot_time' => '11:00:00',
                'max_participants' => 12,
                'price' => 1100,
            ],
            [
                'creative_type_id' => $cooking->id,
                'leader_id' => $leaderThree->id,
                'title' => 'Приготовление стейков',
                'description' => 'Участники научатся выбирать мясо, готовить стейки нужной прожарки и подбирать гарнир с соусом.',
                'session_date' => Carbon::today()->addDays(6)->toDateString(),
                'slot_time' => '15:00:00',
                'max_participants' => 6,
                'price' => 1800,
            ],
            [
                'creative_type_id' => $wood->id,
                'leader_id' => $leaderTwo->id,
                'title' => 'Геометрическая резьба по дереву',
                'description' => 'Знакомство с базовыми элементами геометрической резьбы и создание первых декоративных узоров.',
                'session_date' => Carbon::today()->addDays(7)->toDateString(),
                'slot_time' => '11:00:00',
                'max_participants' => 7,
                'price' => 1300,
            ],
            [
                'creative_type_id' => $wood->id,
                'leader_id' => $leaderOne->id,
                'title' => 'Деревянные игрушки',
                'description' => 'На мастер-классе участники вырезают фигурки животных и знакомятся с безопасной обработкой дерева.',
                'session_date' => Carbon::today()->addDays(9)->toDateString(),
                'slot_time' => '15:00:00',
                'max_participants' => 5,
                'price' => 1600,
            ],
        ];

        foreach ($masterClasses as $masterClassData) {
            MasterClass::updateOrCreate(
                [
                    'leader_id' => $masterClassData['leader_id'],
                    'session_date' => $masterClassData['session_date'],
                    'slot_time' => $masterClassData['slot_time'],
                ],
                $masterClassData,
            );
        }

        $firstMasterClass = MasterClass::query()->first();

        if ($firstMasterClass) {
            $firstMasterClass->participants()->syncWithoutDetaching([$visitor->id]);
        }
    }
}
