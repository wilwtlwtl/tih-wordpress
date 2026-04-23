<?php
/**
 * Seed: 16-article series — Spirits/Beauty/Gourmet/Craft × Vol.1–4
 * Status: draft (下書き保存)
 * Admin trigger: /wp-admin/?tih_seed_series=1
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( ! isset( $_GET['tih_seed_series'] ) || '1' !== $_GET['tih_seed_series'] ) return;

    $result = tih_seed_series_articles();
    wp_die(
        '<h1>TIH Series Seed</h1><pre style="font-size:13px;line-height:1.6">'
        . esc_html( implode( "\n", $result ) )
        . '</pre><p><a href="' . esc_url( admin_url() ) . '">&larr; Dashboard</a></p>'
    );
} );

function tih_seed_series_articles(): array {
    $log = [];

    // --- helpers ---
    $island_id = function ( string $slug ): ?int {
        static $c = [];
        if ( isset( $c[ $slug ] ) ) return $c[ $slug ];
        $p = get_posts( [ 'post_type' => 'islands', 'name' => $slug,
                          'post_status' => 'any', 'numberposts' => 1 ] );
        return $c[ $slug ] = empty( $p ) ? null : $p[0]->ID;
    };

    $term_id = function ( string $slug ): ?int {
        $t = get_term_by( 'slug', $slug, 'theme_category' );
        return $t ? $t->term_id : null;
    };

    // ================================================================
    // Article definitions
    // ================================================================
    $articles = [];

    // ── Spirits Vol.1 ───────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'spirits-vol-1',
        'title'           => 'The Mugi-Koji Revolution: Why Whisky Lovers are Turning to GI Tokyo Shimazake',
        'excerpt'         => 'GI-certified Tokyo Shimazake, the barley-koji manufacturing secret, and why whisky lovers are switching to island shochu.',
        'category'        => 'spirits',
        'menu_order'      => 1,
        'product_name_jp' => '東京島酒 / 情け嶋 ジョナリー',
        'buyee_keyword'   => '東京島酒',
        'price_guide'     => '¥2,500–¥3,500',
        'island_slugs'    => [ 'niijima', 'hachijojima' ],
        'tags'            => [ 'Niijima', 'Hachijojima', 'Shochu', 'GI Tokyo Shimazake' ],
        'img_alt'         => 'Bottles of GI Tokyo Shimazake arranged on a volcanic stone surface',
        'content'         => <<<'HTML'
<h2>1. The &#8220;Third Way&#8221; for Brown Spirits Lovers</h2>
<p>For connoisseurs who cherish the peaty smoke of an Islay Scotch or the velvety vanilla finish of a premium Bourbon, a hidden treasure awaits in the Izu Islands: Tokyo Shimazake. In 2024, these island spirits officially received the &#8220;GI Tokyo Shimazake&#8221; designation (Geographical Indication). This status ensures that, like Champagne or Cognac, the spirit&#8217;s identity is legally protected, guaranteeing it is a product of its unique volcanic terroir and centuries-old tradition. Far from the neon lights of the mainland, these islands have been refining a spirit that is now capturing the attention of global collectors.</p>

<h2>2. The Secret Ingredient: Mugi-Koji (Barley Koji)</h2>
<p>What surprises whisky enthusiasts most about Shimazake is the fusion of Japan&#8217;s ancient Koji (mold culture) with barley. While whisky distillers malt their barley to convert starches into sugars, Tokyo&#8217;s islanders use &#8220;Mugi-Koji&#8221; (barley inoculated with Koji spores). This 100% barley-koji process&#8212;often blended with sweet potatoes&#8212;creates a profile rich in roasted nuts, dark chocolate, and toasted caramel. Distilled with mineral-rich volcanic water, the liquid is powerful when enjoyed neat, yet reveals floral esters and sweet complexity when opened with a splash of water. It is a revolutionary encounter between the earthiness of grain and the mystery of fermentation.</p>

<div class="tih-vig">
<h3>Visual Identification Guide: Spirits Essentials</h3>
<table class="tih-vig__table"><thead><tr><th>Item</th><th>Product Name (JP)</th><th>Role</th></tr></thead>
<tbody>
<tr><td>Introductory Drink</td><td class="tih-vig__jp">情け嶋 ジョナリー</td><td>A barrel-aged barley shochu, perfect for whisky fans.</td></tr>
<tr><td>The Rare One</td><td class="tih-vig__jp">青酎 (Aochu)</td><td>The legendary &#8220;Unicorn&#8221; spirit from Aogashima.</td></tr>
</tbody></table>
<div class="tih-vig__kw-block">
<span>Search Keywords:</span>
<code class="tih-vig__kw">東京島酒 / 青酎</code>
<button class="tih-btn tih-vig__copy" type="button" aria-label="Copy keyword to clipboard">Copy for Search</button>
</div>
</div>
HTML,
    ];

    // ── Spirits Vol.2 ───────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'spirits-vol-2',
        'title'           => 'The Last Unicorn of Aogashima: Deciphering the Smoke and Mystery of Aochu',
        'excerpt'         => 'Aochu — the legendary wild-yeast shochu from a 160-resident volcanic fortress 358 km south of Tokyo — and why collectors call it the Last Unicorn.',
        'category'        => 'spirits',
        'menu_order'      => 2,
        'product_name_jp' => '青酎 (Aochu)',
        'buyee_keyword'   => '青酎',
        'price_guide'     => '¥3,000–¥6,000',
        'island_slugs'    => [ 'aogashima' ],
        'tags'            => [ 'Aogashima', 'Aochu', 'Shochu', 'Wild Yeast' ],
        'img_alt'         => 'Aochu bottle on the rim of Aogashima\'s inner caldera',
        'content'         => <<<'HTML'
<h2>1. A Spirit from a Volcanic Fortress</h2>
<p>Located 358&#8202;km south of Tokyo, Aogashima is a &#8220;double caldera&#8221; island surrounded by sheer cliffs. Reachable only by helicopter or a boat with a high cancellation rate, this secluded fortress is home to just 160 residents. Here, a legendary spirit called &#8220;Aochu&#8221; was once produced solely for local consumption. Because of its extreme rarity and hauntingly unique profile, enthusiasts worldwide have dubbed it &#8220;The Last Unicorn&#8221; of the spirits world.</p>

<h2>2. Wild Fermentation: The Soul of Aochu</h2>
<p>The defining characteristic of Aochu is its &#8220;wilderness.&#8221; While modern distilleries rely on lab-grown yeast, many Aochu producers use indigenous wild yeast, sweet potatoes steamed by volcanic vents (Hingya), and barley koji.</p>
<ul>
<li><strong>The Aroma:</strong> A bold symphony of campfire smoke, earthy umami, and a faint whisper of the salty Pacific breeze.</li>
<li><strong>The Complexity:</strong> Much like fine wine, Aochu varies significantly by the master brewer (Toji), with different vintages and domestic &#8220;terroirs&#8221; to explore.</li>
</ul>
<p>To take a sip of Aochu is to be transported to the bottom of a prehistoric caldera&#8212;a raw, beautiful experience found nowhere else on Earth.</p>
HTML,
    ];

    // ── Spirits Vol.3 ───────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'spirits-vol-3',
        'title'           => 'The Art of Aging: From Volcanic Caves to Stainless Steel &#8212; The Sleeping Spirits of Tokyo',
        'excerpt'         => 'How Tokyo\'s island distillers use Koga stone cellars and oak barrels to create aged spirits that rival the finest Cognacs and whiskies.',
        'category'        => 'spirits',
        'menu_order'      => 3,
        'product_name_jp' => '御神火 琥珀',
        'buyee_keyword'   => '御神火 琥珀',
        'price_guide'     => '¥3,500–¥5,000',
        'island_slugs'    => [ 'niijima', 'oshima' ],
        'tags'            => [ 'Niijima', 'Oshima', 'Aged Shochu', 'Barrel Aged' ],
        'img_alt'         => 'Goshinka Kohaku golden barrel-aged shochu in a glass against volcanic stone',
        'content'         => <<<'HTML'
<h2>1. Time: The Final Ingredient</h2>
<p>While most Japanese shochu is enjoyed young and fresh, the islanders of Tokyo have a secret: Time. In the world of high-end spirits, aging is the bridge between a raw distillate and a masterpiece. In Tokyo&#8217;s islands, this process is influenced by the unique volcanic environment, creating a category of aged spirits that rivals the finest Cognacs and whiskies.</p>

<h2>2. The Volcanic Cellar: Nature&#8217;s Temperature Control</h2>
<p>On islands like Niijima and Oshima, producers utilise the insulating properties of volcanic rock (Koga Stone) to create natural cellars.</p>
<ul>
<li><strong>Stable Maturation:</strong> These stone warehouses maintain a consistent temperature and humidity year-round, allowing the alcohol molecules to bond slowly with water.</li>
<li><strong>The &#8220;Angel&#8217;s Share&#8221;:</strong> Just like in Scotland, a small portion of the spirit evaporates each year, concentrating the flavours of toasted grain, honey, and dried fruits.</li>
</ul>

<h2>3. Oak vs. Stainless: Two Paths to Perfection</h2>
<p>Tokyo Island spirits follow two distinct aging philosophies.</p>
<ul>
<li><strong>Stainless Steel Aging:</strong> Focuses on purity. It removes the &#8220;harshness&#8221; of the alcohol while preserving the raw, earthy umami of the barley and sweet potato.</li>
<li><strong>Barrel Aging (Moriwaka &amp; Goshinka):</strong> Uses oak barrels to infuse the spirit with vanillin and tannins, resulting in a golden liquid that whisky drinkers will find instantly familiar yet intriguingly different.</li>
</ul>

<div class="tih-vig">
<h3>Visual Identification Guide: &#8220;Goshinka Kohaku&#8221; (Oshima)</h3>
<p>A masterpiece of barrel-aged volcanic spirit.</p>
<table class="tih-vig__table"><thead><tr><th>Feature</th><th>Details for Buyers</th></tr></thead>
<tbody>
<tr><td>Appearance</td><td>Deep golden amber, resembling a 12-year-old Highland Scotch.</td></tr>
<tr><td>Aroma</td><td>Rich vanilla, charred oak, and a hint of dark chocolate.</td></tr>
<tr><td>Price Guide</td><td>¥3,500–¥5,000 JPY (720&#8202;ml)</td></tr>
</tbody></table>
<p>Look for a premium black or gold box and the kanji <strong>「長期熟成」</strong> (Long-term Aging) on the label.</p>
<div class="tih-vig__kw-block">
<span>Search Keyword:</span>
<code class="tih-vig__kw">御神火 琥珀</code>
<button class="tih-btn tih-vig__copy" type="button" aria-label="Copy keyword to clipboard">Copy for Search</button>
</div>
</div>
HTML,
    ];

    // ── Spirits Vol.4 ───────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'spirits-vol-4',
        'title'           => 'The Ultimate Pairing Strategy: Salt, Smoke, and Umami &#8212; The Culinary Soulmates of the Islands',
        'excerpt'         => 'Aochu and kusaya, barley shochu and camellia-oil tempura — the science and art of island food-and-spirit pairing.',
        'category'        => 'spirits',
        'menu_order'      => 4,
        'product_name_jp' => '青酎 / くさや / ひんぎゃの塩',
        'buyee_keyword'   => '東京島酒 青酎',
        'price_guide'     => 'Various',
        'island_slugs'    => [ 'aogashima', 'hachijojima', 'toshima' ],
        'tags'            => [ 'Aogashima', 'Hachijojima', 'Toshima', 'Pairing', 'Kusaya' ],
        'img_alt'         => 'Aochu glass alongside grilled kusaya and Hingya salt on a island-wood table',
        'content'         => <<<'HTML'
<h2>1. &#8220;What Grows Together, Goes Together&#8221;</h2>
<p>In the world of gastronomy, there is a golden rule: the best pairing for a spirit is the food from the same soil. Tokyo&#8217;s islands offer a masterclass in this philosophy. The intense, mineral-rich spirits of these islands were born to compete with&#8212;and complement&#8212;the boldest flavours of the Pacific.</p>

<h2>2. The &#8220;Blue Cheese&#8221; Challenge: Aochu &amp; Kusaya</h2>
<p>The most legendary pairing in Tokyo is the combination of Aochu (Aogashima) and Kusaya (Fermented Fish).</p>
<ul>
<li><strong>The Science:</strong> The high alcohol content (35%+) and wild yeast funk of Aochu act as a solvent for the intense oils and salts of the Kusaya.</li>
<li><strong>The Result:</strong> The sharp &#8220;scent&#8221; of the fish is transformed into a creamy, savoury sweetness that lingers on the palate. It is the Japanese equivalent of Roquefort cheese paired with a bold Sauternes or a smoky Islay Malt.</li>
</ul>

<h2>3. The Light Side: Barley Spirits &amp; Camellia Oil</h2>
<p>For a more delicate experience, the barley-based spirits of Hachijojima or Kozushima are the perfect partners for Tempura fried in Toshima Camellia Oil.</p>
<ul>
<li><strong>The Contrast:</strong> The ultra-light, nutty profile of the camellia oil creates a crisp texture that highlights the toasted grain notes of the shochu.</li>
<li><strong>The &#8220;Mizuwari&#8221; Trick:</strong> Drinking the spirit with cold mineral water (Mizuwari) cleanses the palate after every oily bite, making each mouthful feel as fresh as the first.</li>
</ul>

<div class="tih-vig">
<h3>Visual Identification Guide: The Pairing Essentials</h3>
<p>Items to add to your cart for a complete Island Experience.</p>
<table class="tih-vig__table"><thead><tr><th>Item</th><th>Why You Need It</th></tr></thead>
<tbody>
<tr><td class="tih-vig__jp">くさや 瓶詰め</td><td>Shredded and ready to eat; no cooking required.</td></tr>
<tr><td class="tih-vig__jp">ひんぎゃの塩</td><td>Volcanic salt to sprinkle on sashimi while sipping shochu.</td></tr>
<tr><td class="tih-vig__jp">島とうがらし</td><td>A spicy condiment to add heat to the pairing.</td></tr>
</tbody></table>
<div class="tih-vig__kw-block">
<span>Search Keyword:</span>
<code class="tih-vig__kw">東京島酒 青酎</code>
<button class="tih-btn tih-vig__copy" type="button" aria-label="Copy keyword to clipboard">Copy for Search</button>
</div>
</div>
HTML,
    ];

    // ── Beauty Vol.1 ────────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'beauty-vol-1',
        'title'           => 'Beyond Argan Oil: The Volcanic Secret of Toshima&#8217;s 100% Pure Camellia Oil',
        'excerpt'         => 'Toshima\'s camellia oil contains 80%+ oleic acid — higher than argan oil — backed by 300 years of sustainable island cultivation.',
        'category'        => 'beauty',
        'menu_order'      => 1,
        'product_name_jp' => '神代椿 (Kumayo Tsubaki)',
        'buyee_keyword'   => '利島 椿油 神代椿',
        'price_guide'     => '¥3,200–¥5,000',
        'island_slugs'    => [ 'toshima' ],
        'tags'            => [ 'Toshima', 'Camellia Oil', 'J-Beauty', 'Skincare' ],
        'img_alt'         => 'Toshima camellia forest in winter with fallen seeds on volcanic soil',
        'content'         => <<<'HTML'
<h2>1. The World&#8217;s Highest Oleic Acid Content</h2>
<p>In the global beauty industry, Morocco&#8217;s Argan oil has long reigned as the &#8220;Liquid Gold.&#8221; However, on the tiny, conical volcanic island of Toshima in Tokyo, a superior treasure has been protected for over 300 years. The secret lies in its Oleic Acid content. While Argan oil typically contains 45&#8211;50% oleic acid, Toshima&#8217;s Camellia oil boasts a staggering 80% or more. This is one of the highest concentrations found in nature. Because oleic acid is the primary component of human sebum, this oil penetrates the skin with remarkable speed, locking in hydration for hours without leaving a greasy residue.</p>

<h2>2. A Carbon-Neutral Beauty Heritage</h2>
<p>Toshima is a rare &#8220;circular&#8221; island where nearly 80% of the land is covered by ancient camellia forests. This isn&#8217;t a modern industrial plantation; it&#8217;s a sustainable ecosystem that has thrived for centuries. In winter, islanders still hand-pick each seed that falls to the forest floor&#8212;a primitive yet perfect method that ensures the highest purity. Choosing Toshima Camellia oil is more than just skincare; it is an act of supporting a 300-year-old Japanese tradition of carbon-neutral harmony between humans and the volcano.</p>
HTML,
    ];

    // ── Beauty Vol.2 ────────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'beauty-vol-2',
        'title'           => 'The Ritual of &#8220;Kurokami&#8221;: Restoring Glass-Like Shine with Ancient Japanese Hair Wisdom',
        'excerpt'         => 'Since the Heian period, Japanese noblewomen have used camellia oil and boxwood combs for mirror-like hair — the science and ritual behind Kurokami.',
        'category'        => 'beauty',
        'menu_order'      => 2,
        'product_name_jp' => '椿油 / 御蔵島 黄楊櫛',
        'buyee_keyword'   => '利島 椿油',
        'price_guide'     => '¥3,200–¥8,000',
        'island_slugs'    => [ 'toshima', 'mikurajima' ],
        'tags'            => [ 'Toshima', 'Mikurajima', 'Camellia Oil', 'Kurokami', 'Hair Care' ],
        'img_alt'         => 'Boxwood comb resting in a pool of golden camellia oil on lacquerware',
        'content'         => <<<'HTML'
<h2>1. The Secret of the Satin Finish</h2>
<p>Since the Heian period (794&#8211;1185), Japanese noblewomen have been envied for their Kurokami&#8212;jet-black hair that shimmers with a mirror-like lustre. Their secret was not a chemical serum, but the &#8220;Tsuge (Boxwood) comb soaked in Camellia oil.&#8221; Unlike modern silicone-based oils that merely coat the hair&#8217;s surface for a temporary shine, the molecules of Camellia oil travel deep into the hair shaft, repairing damaged cuticles from the inside out and restoring natural elasticity.</p>

<h2>2. Protection from the Modern Elements</h2>
<p>This &#8220;Liquid Gold&#8221; remains the ultimate solution for modern hair care. It functions as a natural barrier against heat styling and UV damage. By applying just one or two drops to damp hair ends, you can transform frizz into a weightless, silk-like texture. For those seeking &#8220;Clean Beauty&#8221; that eliminates all synthetic chemicals, this single-island oil serves as the gold standard, backed by over 1,000 years of proven results.</p>
HTML,
        'crosslink_slug'  => 'craft-vol-3',
        'crosslink_label' => 'Mikurajima Boxwood Comb &#8212; Craft Vol.3',
    ];

    // ── Beauty Vol.3 ────────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'beauty-vol-3',
        'title'           => 'Scalp Detox &amp; The Zen of Massage: The Foundation of Beauty is Volcanic Purity',
        'excerpt'         => 'A weekly Zen ritual using Toshima camellia oil as a pre-shampoo scalp treatment — the Japanese philosophy that the scalp is the face.',
        'category'        => 'beauty',
        'menu_order'      => 3,
        'product_name_jp' => '利島 椿油',
        'buyee_keyword'   => '利島 椿油 神代椿',
        'price_guide'     => '¥3,200–¥5,000',
        'island_slugs'    => [ 'toshima' ],
        'tags'            => [ 'Toshima', 'Camellia Oil', 'Scalp Care', 'J-Beauty' ],
        'img_alt'         => 'Camellia oil dropper bottle with fresh camellia flowers on white linen',
        'content'         => <<<'HTML'
<h2>1. Scalp Health as Skincare</h2>
<p>In the Japanese beauty philosophy, the scalp is treated as an extension of the face. A healthy scalp is the &#8220;soil&#8221; that enables a natural facelift and the growth of beautiful hair. Rich in Vitamin E and potent antioxidants, Toshima Camellia oil is the ideal &#8220;Pre-Shampoo Treatment.&#8221; Its unique molecular structure allows it to gently dissolve hardened sebum and impurities that ordinary shampoos cannot reach, effectively detoxifying the pores.</p>

<h2>2. The Weekly Ritual</h2>
<p>We propose a weekly &#8220;Zen&#8221; ritual for your scalp. Warm a small amount of oil in your palms, apply it to the roots, and massage gently with your fingertips. This process allows the mineral-rich volcanic essence to stimulate blood flow and deeply nourish the follicles. This quiet, meditative moment not only promotes thicker, healthier hair growth but also offers a much-needed mental reset in the midst of a chaotic modern life.</p>
HTML,
        'crosslink_slug'  => 'craft-vol-3',
        'crosslink_label' => 'Mikurajima Boxwood Comb &#8212; Craft Vol.3',
    ];

    // ── Beauty Vol.4 ────────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'beauty-vol-4',
        'title'           => 'The Minimalist&#8217;s Multi-Tool: From Face to Body &#8212; One Bottle to Rule Them All',
        'excerpt'         => 'One bottle replaces night cream, cuticle oil, body lotion, and makeup remover — the ultimate case for Toshima camellia oil as Clean Beauty.',
        'category'        => 'beauty',
        'menu_order'      => 4,
        'product_name_jp' => '神代椿 (Kumayo Tsubaki)',
        'buyee_keyword'   => '利島 椿油 神代椿',
        'price_guide'     => '¥3,200–¥5,000',
        'island_slugs'    => [ 'toshima' ],
        'tags'            => [ 'Toshima', 'Camellia Oil', 'Clean Beauty', 'Minimalism' ],
        'img_alt'         => 'Single dropper bottle of Kumayo Tsubaki camellia oil on a minimalist marble surface',
        'content'         => <<<'HTML'
<h2>1. The Ultimate Clean Beauty Multi-Tasker</h2>
<p>In an era where 10-step skincare routines are the norm, Toshima Camellia oil offers a return to Minimalism. This single bottle replaces your night cream, cuticle oil, body lotion, and even your makeup remover. Because it is non-comedogenic (won&#8217;t clog pores) and hypoallergenic, it is a safe and powerful multi-tool even for the most sensitive skin types.</p>

<h2>2. How to &#8220;Seal&#8221; Your Hydration</h2>
<p>The most effective way to use this volcanic treasure is as the final step of your routine. After applying your water-based moisturiser, press a single drop of warmed oil onto your face with your palms. This creates a &#8220;breathable veil&#8221; that prevents moisture evaporation throughout the night. By morning, you will discover the legendary &#8220;Toshima Glow&#8221; in the mirror&#8212;a radiance born from the perfect balance of moisture and purity.</p>

<div class="tih-vig">
<h3>Visual Identification Guide: The Beauty Masterpieces</h3>
<table class="tih-vig__table"><thead><tr><th>Item</th><th>Product Name (JP)</th><th>Role</th></tr></thead>
<tbody>
<tr><td>Premium Oil</td><td class="tih-vig__jp">神代椿 (Kumayo Tsubaki)</td><td>100% Toshima-grown. The purest flagship brand.</td></tr>
<tr><td>Traditional Comb</td><td class="tih-vig__jp">御蔵島 黄楊櫛</td><td>Boxwood comb from Mikurajima. Soak in oil before use.</td></tr>
</tbody></table>
<div class="tih-vig__kw-block">
<span>Search Keyword:</span>
<code class="tih-vig__kw">利島 椿油 神代椿</code>
<button class="tih-btn tih-vig__copy" type="button" aria-label="Copy keyword to clipboard">Copy for Search</button>
</div>
</div>
HTML,
    ];

    // ── Gourmet Vol.1 ───────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'gourmet-vol-1',
        'title'           => 'The Blue Cheese of the Ocean: Decoding the 400-Year-Old Umami of &#8220;Kusaya&#8221;',
        'excerpt'         => 'Kusaya — Tokyo\'s 400-year-old fermented fish born from a salt crisis — is the umami equivalent of blue cheese: polarising on first sniff, transcendent on first taste.',
        'category'        => 'gourmet',
        'menu_order'      => 1,
        'product_name_jp' => 'くさや',
        'buyee_keyword'   => '新島 くさや 瓶詰め',
        'price_guide'     => '¥800–¥2,500',
        'island_slugs'    => [ 'niijima', 'hachijojima' ],
        'tags'            => [ 'Niijima', 'Hachijojima', 'Kusaya', 'Fermented', 'Gourmet' ],
        'img_alt'         => 'Kusaya drying on bamboo racks in the Niijima ocean breeze',
        'content'         => <<<'HTML'
<h2>1. The &#8220;Fragrant&#8221; History of a Salt Crisis</h2>
<p>During the Edo period, salt was a precious commodity for the islanders of the Izu archipelago&#8212;often more valuable than gold as it was a required tribute to the Shogunate. To conserve this luxury, the people of Niijima refused to discard their brine, reusing it repeatedly to soak their fish. Over centuries, this brine evolved into a complex, living ecosystem of unique microorganisms, giving birth to a fermentation liquid known as Kusaya-mizu. This was the beginning of Kusaya, the ultimate fermented delicacy often referred to as the &#8220;Blue Cheese of the Sea.&#8221;</p>

<h2>2. A Living Ecosystem in a Jar</h2>
<p>To the uninitiated, the scent of Kusaya can be shocking. However, once you venture past the aroma, you discover a treasure trove of aged amino acids (Umami). Much like the terroir of a fine wine, the microbial balance of Kusaya-mizu varies between families and producers, infusing the fish with the distinct personality of each island. With a nutty savoriness and a profound depth of flavour that lingers on the palate, Kusaya is a culinary abyss&#8212;once you cross the threshold, there is no turning back.</p>

<!-- ULTIMATE_PAIRING_PLACEHOLDER -->
HTML,
    ];

    // ── Gourmet Vol.2 ───────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'gourmet-vol-2',
        'title'           => 'The Salt of the Earth: Volcanic Steam and the Birth of &#8220;Hingya Salt&#8221;',
        'excerpt'         => 'Hingya no Shio — crystallised from Kuroshio seawater over 13 days using only Aogashima\'s geothermal steam — carries the memory of the volcano in every crystal.',
        'category'        => 'gourmet',
        'menu_order'      => 2,
        'product_name_jp' => 'ひんぎゃの塩',
        'buyee_keyword'   => '青ヶ島 ひんぎゃの塩',
        'price_guide'     => '¥500–¥1,500',
        'island_slugs'    => [ 'aogashima' ],
        'tags'            => [ 'Aogashima', 'Salt', 'Hingya', 'Volcanic' ],
        'img_alt'         => 'Large Hingya salt crystals close-up with volcanic steam in the background',
        'content'         => <<<'HTML'
<h2>1. Crystallised Volcanic Energy</h2>
<p>On the secluded island of Aogashima, the heat of a volcano still pulses beneath the earth. This volcanic steam, known locally as Hingya, is harnessed to create a salt unlike any other. By slowly evaporating Kuroshio seawater over 13 days using only this natural geothermal heat, islanders produce &#8220;Hingya no Shio.&#8221; Unlike mass-produced salts crystallised through rapid heating, this slow process preserves essential minerals like calcium and magnesium, resulting in large, crunchy crystals with a surprising, mild sweetness.</p>

<h2>2. The Perfect Seasoning for the Minimalist</h2>
<p>This salt is more than a condiment; it is a protagonist that carries the &#8220;memory of the volcano.&#8221; A simple sprinkle over a thick steak or fresh white-fish sashimi dramatically heightens the natural profile of the ingredients. As the large crystals snap on your tongue, they release the mineral-rich resonance of the Pacific. It is the only way to bring the raw energy of Aogashima&#8212;a fortress home to only 160 residents&#8212;directly to your dining table.</p>
HTML,
    ];

    // ── Gourmet Vol.3 ───────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'gourmet-vol-3',
        'title'           => 'The Superfood of the &#8220;Spring Island&#8221;: Ashitaba &#8212; The Plant That Grows Tomorrow',
        'excerpt'         => 'Ashitaba from Hachijojima contains chalcones — rare polyphenols found almost nowhere else in nature — making it a J-Superfood sensation for detox and anti-aging.',
        'category'        => 'gourmet',
        'menu_order'      => 3,
        'product_name_jp' => '明日葉 パウダー',
        'buyee_keyword'   => '八丈島 明日葉',
        'price_guide'     => '¥1,500–¥3,000',
        'island_slugs'    => [ 'hachijojima' ],
        'tags'            => [ 'Hachijojima', 'Ashitaba', 'Superfood', 'Health' ],
        'img_alt'         => 'Fresh ashitaba leaves harvested on Hachijojima against a tropical backdrop',
        'content'         => <<<'HTML'
<h2>1. The Legend of the &#8220;Tomorrow&#8217;s Leaf&#8221;</h2>
<p>Ashitaba, which literally translates to &#8220;Tomorrow&#8217;s Leaf,&#8221; is a plant so resilient it is said that if you harvest a leaf today, a new bud will appear tomorrow. Native to the Izu Islands, particularly Hachijojima, it has been revered since ancient times as a medicinal herb for longevity. Modern scientific analysis has revealed that Ashitaba contains &#8220;Chalcones&#8221;&#8212;rare polyphenols found almost nowhere else in nature. This has made it a global sensation among the health-conscious seeking natural detox and anti-aging solutions.</p>

<h2>2. A Bittersweet Symphony</h2>
<p>The charm of Ashitaba lies in its powerful, vibrant flavour. It possesses a crisp bitterness similar to kale, complemented by a noble aroma reminiscent of Japanese wild parsley. While islanders enjoy it as tempura or tossed with Kusaya, international fans are now incorporating Ashitaba powder into smoothies and lattes as a &#8220;J-Superfood.&#8221; Grown in the harsh volcanic environment, this potent green is designed to revitalise your body from the inside out.</p>
HTML,
    ];

    // ── Gourmet Vol.4 ───────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'gourmet-vol-4',
        'title'           => 'The Frontier of Spirits-Aged Cuisine: Savoring the Synergy of Islands',
        'excerpt'         => 'The science and art of pairing island food with island shochu — and how bottled kusaya and Hingya salt bring the volcanic table into any kitchen worldwide.',
        'category'        => 'gourmet',
        'menu_order'      => 4,
        'product_name_jp' => 'くさや 瓶詰め / ひんぎゃの塩',
        'buyee_keyword'   => '東京島 くさや 青酎',
        'price_guide'     => 'Various',
        'island_slugs'    => [ 'aogashima', 'niijima' ],
        'tags'            => [ 'Aogashima', 'Niijima', 'Kusaya', 'Pairing', 'Aochu' ],
        'img_alt'         => 'Bottled kusaya and Hingya salt laid out with a glass of Aochu shochu',
        'content'         => <<<'HTML'
<h2>1. The Science of the Ultimate Pairing</h2>
<p>The final destination of any culinary journey is the art of the &#8220;pairing.&#8221; The intense Umami of Kusaya requires a partner with an equally powerful soul&#8212;and only the &#8220;Island Spirits&#8221; (Shimazake) born of the same volcanic earth can meet the challenge. The raw, smoky alcohol of Aogashima&#8217;s Aochu, in particular, fuses with the amino acids of the fish on the palate, transforming the experience into a sweet, sublime finish that feels entirely new.</p>

<h2>2. Bringing the Island Table Home</h2>
<p>For those who wish to experience these authentic flavours without worrying about international shipping or storage, the islanders have innovated:</p>
<ul>
<li><strong>Bottled Kusaya:</strong> Carefully roasted and preserved in oil to lock in the Umami while containing the aroma for a modern kitchen.</li>
<li><strong>Salt &amp; Chili:</strong> A spice blend mixing Hingya salt with potent island-grown chilies.</li>
</ul>
<p>These &#8220;Portable Island Treasures&#8221; are available via Buyee. Tonight, your kitchen connects to the remote volcanic peaks of Tokyo.</p>

<div class="tih-vig">
<h3>Visual Identification Guide: Gourmet Treasures</h3>
<table class="tih-vig__table"><thead><tr><th>Item</th><th>Product Name (JP)</th><th>Key Search Keyword</th></tr></thead>
<tbody>
<tr><td>Elite Salt</td><td class="tih-vig__jp">ひんぎゃの塩</td><td>青ヶ島 ひんぎゃの塩</td></tr>
<tr><td>Kusaya Jar</td><td class="tih-vig__jp">くさや 瓶詰め</td><td>新島 くさや 瓶</td></tr>
<tr><td>Superfood</td><td class="tih-vig__jp">明日葉 パウダー</td><td>八丈島 明日葉</td></tr>
</tbody></table>
<div class="tih-vig__kw-block">
<span>Search Keyword:</span>
<code class="tih-vig__kw">東京島 くさや 青酎</code>
<button class="tih-btn tih-vig__copy" type="button" aria-label="Copy keyword to clipboard">Copy for Search</button>
</div>
</div>
HTML,
        'crosslink_slug'  => 'spirits-vol-1',
        'crosslink_label' => 'The Mugi-Koji Revolution &#8212; Spirits Vol.1',
    ];

    // ── Craft Vol.1 ─────────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'craft-vol-1',
        'title'           => 'The Emerald of the Pacific: Why Niijima Glass is the World&#8217;s Only Volcanic Olive Green Art',
        'excerpt'         => 'Niijima glass is forged from Koga stone — a volcanic tuff found only on Niijima and Lipari, Italy — creating an olive green that no industrial process can replicate.',
        'category'        => 'craft',
        'menu_order'      => 1,
        'product_name_jp' => '新島ガラス',
        'buyee_keyword'   => '新島ガラス',
        'price_guide'     => '¥3,000–¥30,000',
        'island_slugs'    => [ 'niijima' ],
        'tags'            => [ 'Niijima', 'Glass Art', 'Koga Stone', 'Craft' ],
        'img_alt'         => 'Niijima glass sake cup in olive green held up to the light of the Pacific',
        'content'         => <<<'HTML'
<h2>1. Born from Rare Volcanic Stone</h2>
<p>Typically, glass is made from silica sand. However, the legendary &#8220;Niijima Glass&#8221; is forged directly from a rare volcanic rock found on the island called Koga Stone (Rhyolite). This mineral is incredibly rare, found in abundance only on Niijima and the island of Lipari in Italy. When this natural stone is melted at temperatures exceeding 1,400&#8202;&#176;C (2,550&#8202;&#176;F), it undergoes a miraculous transformation into a breathtaking, natural &#8220;Olive Green&#8221;&#8212;achieved without a single drop of artificial dye.</p>

<h2>2. A Colour That Changes with the Light</h2>
<p>Often referred to as the &#8220;Emerald of the Pacific,&#8221; this glass is celebrated for its dynamic personality. Its hue shifts dramatically depending on the quality of light: appearing as a vibrant forest green under the morning sun, and transitioning into a deep, amber-hued olive under warm evening lamplight. This colour, a crystallisation of volcanic energy, is a unique gift from the Earth that can never be replicated by industrial means. Holding a piece of Niijima Glass is like holding the soul of the white-sand volcanic island itself.</p>
HTML,
    ];

    // ── Craft Vol.2 ─────────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'craft-vol-2',
        'title'           => 'The Golden Silk: Kihachijo &#8212; The 100-Year Lustre of Hachijojima&#8217;s Botanical Dye',
        'excerpt'         => 'Kihachijo silk is dyed with Kobunagusa plants, volcanic mud, and wood ash — a colour so stable it is said to never fade even after 100 years.',
        'category'        => 'craft',
        'menu_order'      => 2,
        'product_name_jp' => '黄八丈',
        'buyee_keyword'   => '黄八丈 小物',
        'price_guide'     => '¥5,000–¥50,000',
        'island_slugs'    => [ 'hachijojima' ],
        'tags'            => [ 'Hachijojima', 'Kihachijo', 'Silk', 'Textile' ],
        'img_alt'         => 'Kihachijo silk fabric in brilliant golden yellow under subtropical sunlight',
        'content'         => <<<'HTML'
<h2>1. The Brilliant Yellow of the Subtropics</h2>
<p>Hachijojima is home to Kihachijo, a legendary silk textile counted among Japan&#8217;s three great &#8220;Tsumugi&#8221; weaves. The vibrant golden hue that defines this craft is extracted from Kobunagusa (Kariyasu), a plant native to the island. Rejecting chemical dyes, the artisans rely solely on island plants, volcanic mud, and wood ash in a repetitive, labour-intensive dyeing process. The resulting colour is so stable it is said to &#8220;never fade even after 100 years,&#8221; growing more lustrous and profound the more it is used.</p>

<h2>2. Modern Elegance for the Global Collector</h2>
<p>Once a highly-prized tribute to the Shogun&#8217;s court, this noble silk has been reimagined for contemporary lifestyles. While a full kimono is a lifetime investment, Kihachijo neckties, card cases, and wallets&#8212;available through Buyee&#8212;are sophisticated ways to integrate Japan&#8217;s &#8220;Functional Beauty&#8221; into your daily life. The warmth of the handwork and the radiant gold, reminiscent of the subtropical sun, offer a distinct elegance to the modern collector.</p>
HTML,
    ];

    // ── Craft Vol.3 ─────────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'craft-vol-3',
        'title'           => 'The Boxwood Masterpiece: Mikurajima Boxwood &#8212; The World&#8217;s Hardest Wood for the Finest Tools',
        'excerpt'         => 'Mikurajima hon-tsuge boxwood — the densest wood in Japan — and the Edo-period ritual of soaking it in camellia oil for a lifetime of perfect hair care.',
        'category'        => 'craft',
        'menu_order'      => 3,
        'product_name_jp' => '御蔵島 本黄楊 櫛',
        'buyee_keyword'   => '御蔵島 本黄楊 櫛',
        'price_guide'     => '¥3,000–¥15,000',
        'island_slugs'    => [ 'mikurajima' ],
        'tags'            => [ 'Mikurajima', 'Boxwood', 'Comb', 'Tsuge' ],
        'img_alt'         => 'Mikurajima hon-tsuge boxwood comb resting on a slice of boxwood timber',
        'content'         => <<<'HTML'
<h2>1. Growing in the Mist of the Sea</h2>
<p>Surrounded by sheer cliffs and home to wild dolphins, Mikurajima is the sanctuary of the Mikurajima Hon-Tsuge (Boxwood). In the island&#8217;s deep, maritime mists, these trees grow with incredible slowness over decades. This slow growth results in a grain that is remarkably dense and hard&#8212;so much so that it is considered the &#8220;Phantom Wood,&#8221; prized by world-class artisans for the finest Japanese seals and hair combs.</p>

<h2>2. A Lifetime Companion</h2>
<p>A comb made from Mikurajima boxwood is more than a tool; it is a hair-care miracle. It eliminates static electricity and imparts a natural shine to the hair. The ultimate Japanese self-care ritual, practised since the Edo period, involves soaking this comb in Toshima Camellia Oil before use. Over 10 or 20 years, the wood matures into a beautiful, honey-coloured amber, becoming a bespoke treasure that grows with its owner.</p>
HTML,
        'crosslink_slug'  => 'beauty-vol-1',
        'crosslink_label' => 'Toshima Camellia Oil &#8212; Beauty Vol.1',
    ];

    // ── Craft Vol.4 ─────────────────────────────────────────────────
    $articles[] = [
        'slug'            => 'craft-vol-4',
        'title'           => 'The Spirit of &#8220;Moyai&#8221;: Koga-Stone Carving &#8212; The Soul of the Community',
        'excerpt'         => 'Moyai — statues hand-carved from Niijima\'s Koga stone — embody the island\'s communal spirit of working together, and are now entering global interior design.',
        'category'        => 'craft',
        'menu_order'      => 4,
        'product_name_jp' => 'コーガ石 クラフト',
        'buyee_keyword'   => 'コーガ石 クラフト',
        'price_guide'     => '¥1,500–¥8,000',
        'island_slugs'    => [ 'niijima' ],
        'tags'            => [ 'Niijima', 'Koga Stone', 'Moyai', 'Stone Craft' ],
        'img_alt'         => 'Moyai statue carved from Koga stone on the Niijima seafront promenade',
        'content'         => <<<'HTML'
<h2>1. More Than Just Stone</h2>
<p>Walking the streets of Niijima, one encounters countless expressive stone statues known as Moyai. These are hand-carved from the island&#8217;s signature Koga Stone. The word &#8220;Moyai&#8221; comes from the island dialect meaning &#8220;to work together&#8221; or &#8220;to help one another.&#8221; This art form is the physical embodiment of the island&#8217;s communal spirit. Koga stone is porous, lightweight, fire-resistant, and easy to carve, making it the literal and metaphorical foundation of the community.</p>

<h2>2. Bringing Volcanic Texture to Your Home</h2>
<p>Today, modern crafts utilising the raw texture of Koga stone are gaining international attention. Rugged yet warm, stone coasters, planters, and candle holders add a touch of &#8220;Volcanic Wildness&#8221; to urban interiors. Far from the skyscrapers of central Tokyo, these pieces bring the quiet strength of island solidarity&#8212;the spirit of Moyai&#8212;into your living room.</p>

<div class="tih-vig">
<h3>Visual Identification Guide: Craft Masterpieces</h3>
<table class="tih-vig__table"><thead><tr><th>Item</th><th>Product Name (JP)</th><th>Value Point</th></tr></thead>
<tbody>
<tr><td>Glass Art</td><td class="tih-vig__jp">新島ガラス</td><td>Natural olive green born from volcanic rock.</td></tr>
<tr><td>Silk Accessory</td><td class="tih-vig__jp">黄八丈 小物</td><td>Brilliant golden silk that lasts 100 years.</td></tr>
<tr><td>Luxury Comb</td><td class="tih-vig__jp">御蔵島 本黄楊 櫛</td><td>The world&#8217;s finest boxwood for hair health.</td></tr>
<tr><td>Stone Craft</td><td class="tih-vig__jp">コーガ石 クラフト</td><td>Authentic volcanic texture for modern interiors.</td></tr>
</tbody></table>
<div class="tih-vig__kw-block">
<span>Search Keyword:</span>
<code class="tih-vig__kw">コーガ石 クラフト</code>
<button class="tih-btn tih-vig__copy" type="button" aria-label="Copy keyword to clipboard">Copy for Search</button>
</div>
</div>
HTML,
    ];

    // ================================================================
    // Process: create / skip each article
    // ================================================================
    $created_ids = [];

    foreach ( $articles as $a ) {
        $existing = get_posts( [
            'post_type'   => 'treasures',
            'name'        => $a['slug'],
            'post_status' => 'any',
            'numberposts' => 1,
        ] );

        if ( ! empty( $existing ) ) {
            $log[]                     = "[SKIP] {$a['slug']} already exists (ID: {$existing[0]->ID})";
            $created_ids[ $a['slug'] ] = $existing[0]->ID;
            continue;
        }

        // Resolve category term
        $tid = $term_id( $a['category'] );
        if ( ! $tid ) {
            $names = [ 'spirits' => 'Spirits', 'beauty' => 'Beauty',
                       'gourmet' => 'Gourmet',  'craft'  => 'Craft' ];
            $ins = wp_insert_term( $names[ $a['category'] ] ?? ucfirst( $a['category'] ),
                                   'theme_category', [ 'slug' => $a['category'] ] );
            $tid = is_wp_error( $ins ) ? null : $ins['term_id'];
        }

        // Create post as draft
        $pid = wp_insert_post( [
            'post_type'    => 'treasures',
            'post_status'  => 'draft',
            'post_title'   => $a['title'],
            'post_name'    => $a['slug'],
            'post_excerpt' => $a['excerpt'],
            'post_content' => $a['content'],
            'menu_order'   => $a['menu_order'],
        ], true );

        if ( is_wp_error( $pid ) ) {
            $log[] = "[ERROR] {$a['slug']}: " . $pid->get_error_message();
            continue;
        }

        $created_ids[ $a['slug'] ] = $pid;

        // Category term
        if ( $tid ) {
            wp_set_post_terms( $pid, [ $tid ], 'theme_category' );
        }

        // Tags (island names)
        if ( ! empty( $a['tags'] ) ) {
            wp_set_post_tags( $pid, $a['tags'] );
        }

        // ACF fields
        update_field( 'product_name_jp', $a['product_name_jp'], $pid );
        update_field( 'buyee_keyword',   $a['buyee_keyword'],   $pid );
        update_field( 'price_guide',     $a['price_guide'],     $pid );

        // Featured image alt text (stored in post_meta for later upload)
        update_post_meta( $pid, '_tih_img_alt', $a['img_alt'] );

        // Island relationship
        $island_ids = [];
        foreach ( $a['island_slugs'] as $islug ) {
            $iid = $island_id( $islug );
            if ( $iid ) {
                $island_ids[] = $iid;
                // Back-link: add to island's related_treasures
                $cur     = get_field( 'related_treasures', $iid ) ?: [];
                $cur_ids = array_map( fn( $t ) => is_object( $t ) ? $t->ID : (int) $t, $cur );
                if ( ! in_array( $pid, $cur_ids, true ) ) {
                    update_field( 'related_treasures', array_merge( $cur_ids, [ $pid ] ), $iid );
                }
            }
        }
        if ( ! empty( $island_ids ) ) {
            update_field( 'featured_island', $island_ids, $pid );
        }

        $log[] = "[OK] {$a['slug']} (ID: $pid, draft)";
    }

    // ================================================================
    // Second pass: cross-links
    // ================================================================
    $crosslinks = [
        'beauty-vol-2'  => [ 'slug' => 'craft-vol-3',   'label' => 'Mikurajima Boxwood Comb &#8212; Craft Vol.3' ],
        'beauty-vol-3'  => [ 'slug' => 'craft-vol-3',   'label' => 'Mikurajima Boxwood Comb &#8212; Craft Vol.3' ],
        'gourmet-vol-4' => [ 'slug' => 'spirits-vol-1', 'label' => 'The Mugi-Koji Revolution &#8212; Spirits Vol.1' ],
        'craft-vol-3'   => [ 'slug' => 'beauty-vol-1',  'label' => 'Toshima Camellia Oil &#8212; Beauty Vol.1' ],
    ];

    foreach ( $crosslinks as $from_slug => $to ) {
        if ( ! isset( $created_ids[ $from_slug ], $created_ids[ $to['slug'] ] ) ) {
            continue;
        }
        $from_id = $created_ids[ $from_slug ];
        $to_url  = home_url( '/treasures/' . $to['slug'] . '/' );

        $link_html = sprintf(
            "\n\n" . '<div class="tih-series-crosslink">'
            . '<strong>Related:</strong> <a href="%s">%s</a>'
            . '</div>',
            esc_url( $to_url ),
            $to['label']
        );

        $post        = get_post( $from_id );
        $new_content = $post->post_content . $link_html;
        wp_update_post( [ 'ID' => $from_id, 'post_content' => $new_content ] );
        $log[] = "[LINK] {$from_slug} → {$to['slug']}";
    }

    // ================================================================
    // Summary
    // ================================================================
    $log[] = '';
    $log[] = '=== Summary ===';
    $log[] = 'Treasures (all statuses): '
        . array_sum( (array) wp_count_posts( 'treasures' ) );
    $log[] = '';
    $log[] = '=== Draft URLs (published form) ===';
    foreach ( $created_ids as $slug => $id ) {
        $log[] = home_url( '/treasures/' . $slug . '/' );
    }

    return $log;
}
