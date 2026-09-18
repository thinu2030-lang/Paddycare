<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    protected $fillable = [
        'user_id', 'seed_id', 'seed_name', 'sowing_date', 'harvest_date', 'maturity_days',
        'task1_done', 'task2_done', 'task3_done', 'task4_done', 'task5_done',
        'task6_done', 'task7_done', 'task8_done', 'task9_done', 'task10_done',
    ];

    protected $casts = [
        'sowing_date' => 'date',
        'harvest_date' => 'date',
    ];

    public function farmer() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seed() {
        return $this->belongsTo(Seed::class);
    }

    // 10-task timeline definition (offset days, label, icon, done flag, description)
    public function getTasksAttribute()
    {
        $sow = $this->sowing_date->copy();
        return [
            ['day' => -10, 'title' => 'Land / Soil Preparation', 'icon' => '🚜', 'desc' => 'Plowing, flooding & soaking, leveling before sowing.', 'date' => $sow->copy()->subDays(10), 'done' => $this->task1_done, 'field' => 'task1_done'],
            ['day' => 0,   'title' => 'Sowing / Transplanting',  'icon' => '🌱', 'desc' => 'Crop start date.', 'date' => $sow->copy(), 'done' => $this->task2_done, 'field' => 'task2_done'],
            ['day' => 5,   'title' => 'Basal Fertilizer',        'icon' => '💧', 'desc' => 'Apply TSP + MOP.', 'date' => $sow->copy()->addDays(5), 'done' => $this->task3_done, 'field' => 'task3_done'],
            ['day' => 14,  'title' => 'First Top Dressing',      'icon' => '🧪', 'desc' => 'Apply Urea (active tillering stage).', 'date' => $sow->copy()->addDays(14), 'done' => $this->task4_done, 'field' => 'task4_done'],
            ['day' => 18,  'title' => 'First Weeding',           'icon' => '✂️', 'desc' => 'Manual or rotary weeding.', 'date' => $sow->copy()->addDays(18), 'done' => $this->task5_done, 'field' => 'task5_done'],
            ['day' => 35,  'title' => 'Second Top Dressing',     'icon' => '🧪', 'desc' => 'Urea + MOP (panicle initiation).', 'date' => $sow->copy()->addDays(35), 'done' => $this->task6_done, 'field' => 'task6_done'],
            ['day' => 35,  'title' => 'Second Weeding',          'icon' => '✂️', 'desc' => 'Final weeding round.', 'date' => $sow->copy()->addDays(35), 'done' => $this->task7_done, 'field' => 'task7_done'],
            ['day' => 45,  'title' => 'Critical Water Period',   'icon' => '💧', 'desc' => 'Maintain consistent flooding (reproductive stage).', 'date' => $sow->copy()->addDays(45), 'done' => $this->task8_done, 'field' => 'task8_done'],
            ['day' => 90,  'title' => 'Drain Field',             'icon' => '💧', 'desc' => 'Stop irrigation before harvest.', 'date' => $sow->copy()->addDays(90), 'done' => $this->task9_done, 'field' => 'task9_done'],
            ['day' => $this->maturity_days, 'title' => 'Harvest', 'icon' => '🌾', 'desc' => 'Harvest the crop.', 'date' => $this->harvest_date, 'done' => $this->task10_done, 'field' => 'task10_done'],
        ];
    }

    public function getProgressPercentAttribute() {
        $tasks = $this->tasks;
        $doneCount = count(array_filter($tasks, fn($t) => $t['done']));
        return round(($doneCount / count($tasks)) * 100);
    }

    public function getDaysToHarvestAttribute() {
        return now()->diffInDays($this->harvest_date, false);
    }

    public function getCurrentStageAttribute() {
        $today = now()->startOfDay();
        $tasks = $this->tasks;
        $current = null;
        foreach ($tasks as $t) {
            if ($t['date']->lte($today)) $current = $t;
        }
        return $current ?? $tasks[0];
    }
}