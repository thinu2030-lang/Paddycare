<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)
                           ->latest()->take(6)->get();
        return view('home.index', compact('articles'));
    }

    public function articles()
    {
        $articles = Article::where('is_published', true)
                           ->latest()->paginate(9);
        return view('home.articles', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
                          ->where('is_published', true)
                          ->firstOrFail();

        $article->increment('views');

        // Related articles — same category, exclude current
        $related = Article::where('is_published', true)
                          ->where('category', $article->category)
                          ->where('id', '!=', $article->id)
                          ->latest()
                          ->take(3)
                          ->get();

        return view('home.show', compact('article', 'related'));
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'phone'    => 'nullable|string|max:20',
            'district' => 'required|string',
            'subject'  => 'required|string|max:255',
            'message'  => 'required|string',
        ]);

        \Mail::send('emails.contact', [
            'senderName'     => $request->name,
            'senderEmail'    => $request->email,
            'senderPhone'    => $request->phone ?? 'Not provided',
            'senderDistrict' => $request->district,
            'subject'        => $request->subject,
            'userMessage'    => $request->message,
        ], function ($mail) use ($request) {
            $mail->to(config('mail.from.address'))
                 ->subject('[PaddyCare Contact] ' . $request->subject)
                 ->replyTo($request->email, $request->name);
        });

        return back()->with('success', 'Your message has been sent successfully! We will get back to you within 24 hours.');
    }

    public function guide($topic)
    {
        if ($topic === 'weed-control') $topic = 'weed';
        if ($topic === 'pest-control') $topic = 'pest';

        $guides = [
            'irrigation' => [
                'title'    => 'Irrigation Management for Paddy',
                'icon'     => '💧',
                'color'    => '#e3f2fd',
                'intro'    => 'Proper water management is the most critical factor in paddy cultivation. Water stress at any stage can significantly reduce yield.',
                'sections' => [
                    ['heading' => 'Water Requirements by Growth Stage', 'content' => 'Paddy requires different water levels at each growth stage. During land preparation, flood the field with 5-10cm of water. At transplanting, maintain 2-3cm. During tillering (weeks 2-6), keep 5cm flood depth. At panicle initiation and flowering (weeks 7-10), maintain 5-7cm — this is the most critical period. Begin draining 2 weeks before harvest.'],
                    ['heading' => 'Mid-Season Drainage (AWD)', 'content' => 'Alternate Wetting and Drying (AWD) is a water-saving technique recommended by the Department of Agriculture. Drain the field for 7-10 days during mid-tillering stage. This strengthens root systems, reduces methane emissions, and saves 20-30% of irrigation water without yield loss.'],
                    ['heading' => 'Signs of Water Stress', 'content' => 'Watch for leaf rolling (early sign), bluish-green leaf color, and reduced tillering. If leaves roll in early morning, irrigate immediately. Water stress during flowering causes spikelet sterility and severe yield loss.'],
                    ['heading' => 'Common Irrigation Mistakes', 'content' => 'Avoid continuous flooding throughout the season — it wastes water and promotes disease. Do not drain too early before harvest as this causes unfilled grains. Ensure uniform water distribution across the field to prevent uneven crop growth.'],
                ]
            ],
            'fertilizer' => [
                'title'    => 'Fertilizer Application Guide',
                'icon'     => '🧪',
                'color'    => '#f3e5f5',
                'intro'    => 'Balanced fertilizer application is key to achieving maximum paddy yield. The Department of Agriculture Sri Lanka recommends specific nutrient ratios for each district.',
                'sections' => [
                    ['heading' => 'Basal Fertilizer (At Transplanting)', 'content' => 'Apply Triple Super Phosphate (TSP) at 45kg/ha and Muriate of Potash (MOP) at 45kg/ha as basal dressing. Apply 3-5 days after transplanting when the field has a thin film of water. This provides essential phosphorus for root development and potassium for disease resistance.'],
                    ['heading' => 'First Top Dressing (2-3 Weeks)', 'content' => 'Apply Urea at 75kg/ha during active tillering stage (14-21 days after transplanting). Drain the field slightly before application and re-flood after 2 days. This nitrogen boost promotes maximum tiller development and increases the number of productive tillers.'],
                    ['heading' => 'Second Top Dressing (5-6 Weeks)', 'content' => 'Apply Urea at 55kg/ha and MOP at 45kg/ha at panicle initiation stage (35-40 days). This is the most important dressing for filling grains and improving harvest quality. Ensure the field has water when applying.'],
                    ['heading' => 'Signs of Nutrient Deficiency', 'content' => 'Nitrogen deficiency: yellowing of older leaves from tip. Phosphorus deficiency: purple discoloration of leaves. Potassium deficiency: brown scorching of leaf tips. Zinc deficiency: brown spots on new leaves with mid-rib remaining green — apply zinc sulfate at 25kg/ha.'],
                ]
            ],
            'weed' => [
                'title'    => 'Weed Control in Paddy Fields',
                'icon'     => '✂️',
                'color'    => '#e8f5e9',
                'intro'    => 'Weeds compete with paddy for nutrients, water, and sunlight. Uncontrolled weeds can reduce yield by 20-50%. Early and effective weed control is essential.',
                'sections' => [
                    ['heading' => 'Critical Weed-Free Period', 'content' => 'The first 30 days after transplanting is the critical weed-free period. Weeds established before day 30 cause the greatest yield loss. Maintain your field weed-free during this period through manual weeding, rotary weeding, or herbicide application.'],
                    ['heading' => 'Manual and Mechanical Weeding', 'content' => 'First weeding at 2-3 weeks after transplanting using a rotary weeder between rows. Second weeding at 4-5 weeks. A rotary weeder covers 0.1-0.2 ha/day compared to 0.02 ha/day for hand weeding. Rotary weeding also aerates the soil and incorporates weeds as green manure.'],
                    ['heading' => 'Common Paddy Weeds in Sri Lanka', 'content' => 'Echinochloa crus-galli (Kukul tana) is the most damaging grass weed. Sphenoclea zeylanica (Sudu kakilla) and Monochoria vaginalis (Nil manel) are common broadleaf weeds. Cyperus difformis and C. iria are sedge weeds that are harder to control with grass herbicides.'],
                    ['heading' => 'Herbicide Recommendations', 'content' => 'For grass weeds: Pretilachlor 30.7% EC at 1.25L/ha applied 3-5 days after transplanting. For broadleaf and sedge weeds: 2,4-D at 1kg a.i./ha at 3-4 weeks. Always drain the field before herbicide application and re-flood after 2-3 days.'],
                ]
            ],
            'pest' => [
                'title'    => 'Pest Control and Management',
                'icon'     => '🐛',
                'color'    => '#fff3e0',
                'intro'    => 'Paddy pests can cause significant yield losses. Integrated Pest Management (IPM) combines cultural, biological, and chemical controls for sustainable pest management.',
                'sections' => [
                    ['heading' => 'Brown Planthopper (BPH)', 'content' => 'BPH is the most destructive paddy pest in Sri Lanka, causing hopperburn. Monitor fields twice weekly — action threshold is 10 BPH/hill at tillering. Avoid excessive nitrogen. Drain field for 2-3 days to disrupt BPH breeding. Use Buprofezin 25% WP at 500g/ha or Imidacloprid 17.8% SL at 250ml/ha only when threshold is exceeded.'],
                    ['heading' => 'Stem Borers (Dead Heart / White Ear)', 'content' => 'Yellow stem borer causes dead heart at vegetative stage and white ear at reproductive stage. Monitor egg masses on leaves — action threshold is 1 egg mass/5 hills. Release Trichogramma japonicum parasitoids at 1.5 lakh/ha. Chemical: Cartap hydrochloride 4G at 25kg/ha or Chlorantraniliprole 18.5% SC at 150ml/ha.'],
                    ['heading' => 'Leaf Folder', 'content' => 'Leaf folder caterpillars fold leaves and scrape green tissue, leaving white papery streaks. Economic threshold is 1 larva/hill at vegetative stage. Encourage natural enemies like spiders and parasitoids. Chemical control only when necessary: Quinalphos 25% EC at 1L/ha.'],
                    ['heading' => 'Integrated Pest Management (IPM)', 'content' => 'IPM reduces pesticide use by 50% while maintaining yields. Key practices: use resistant varieties, maintain balanced nutrition, avoid mid-season nitrogen excess, encourage natural enemies (spiders, dragonflies, birds), use light traps to monitor adult moths, and apply chemicals only when economic thresholds are exceeded.'],
                ]
            ],
            'seed' => [
                'title'    => 'Seed Selection and Management',
                'icon'     => '🌱',
                'color'    => '#e0f7fa',
                'intro'    => 'Choosing the right seed variety for your district and season is the foundation of successful paddy cultivation.',
                'sections' => [
                    ['heading' => 'Choosing the Right Variety', 'content' => 'Select varieties recommended by the Department of Agriculture for your district and season. BG 352, BG 358, and BG 359 are popular high-yielding varieties for the wet zone. AT 362 and BG 300 perform well in the dry zone. Always match variety maturity period to your season length.'],
                    ['heading' => 'Seed Quality Standards', 'content' => 'Use certified seeds with minimum 80% germination rate. Seeds should be free from disease, weed seeds, and foreign matter. Always purchase from registered seed suppliers or the Seed Certification Service.'],
                    ['heading' => 'Seed Treatment', 'content' => 'Soak seeds in clean water for 24 hours. Discard floating seeds. Treat seeds with Carbendazim 50% WP at 2g/kg seed to prevent seed-borne diseases. Incubate seeds in damp gunny bags for 24-48 hours until radicle emerges.'],
                    ['heading' => 'Nursery Management', 'content' => 'Prepare nursery beds of 1m width with good drainage. Apply 500g urea per 100m² nursery area at 7 days. Pull seedlings at 21-25 days for transplanting. Healthy seedlings should be 20-25cm tall with strong roots.'],
                ]
            ],
            'harvest' => [
                'title'    => 'Harvest Planning and Management',
                'icon'     => '🌾',
                'color'    => '#fce4ec',
                'intro'    => 'Timely and proper harvesting is crucial to minimize losses and maintain grain quality.',
                'sections' => [
                    ['heading' => 'When to Harvest', 'content' => 'Harvest when 80-85% of grains on the panicle are golden yellow. Grain moisture content should be 20-22% at harvest. Too early = immature green grains. Too late = grain shattering and reduced quality.'],
                    ['heading' => 'Pre-Harvest Field Drainage', 'content' => 'Drain the field 10-14 days before harvest to allow soil to firm up for machinery access and reduce grain moisture.'],
                    ['heading' => 'Harvesting Methods', 'content' => 'Manual harvesting with sickles is common for small plots. Reaper-binders reduce harvest time by 70%. Combine harvesters complete harvesting and threshing in one operation.'],
                    ['heading' => 'Post-Harvest Handling', 'content' => 'Thresh immediately after harvesting. Sun-dry paddy to 14% moisture content before storage. Store in moisture-proof bags or silos. Properly dried paddy can be kept for 6-12 months.'],
                ]
            ],
        ];

        if (!isset($guides[$topic])) {
            abort(404);
        }

        $guide           = $guides[$topic];
        $relatedArticles = Article::where('category', $topic)
                                  ->where('is_published', 1)
                                  ->latest()->take(3)->get();

        return view('home.guide', compact('guide', 'topic', 'relatedArticles'));
    }
}