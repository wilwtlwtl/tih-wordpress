<?php
/**
 * Full island & product seed — 11 islands + signature products per category
 *
 * WP-CLI: wp eval-file wp-content/plugins/tih-core/includes/seed-all-islands.php
 * Admin:  /wp-admin/?tih_seed_all=1
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( ! isset( $_GET['tih_seed_all'] ) || '1' !== $_GET['tih_seed_all'] ) return;
    $result = tih_seed_all_islands();
    wp_die(
        '<h1>TIH Full Seed</h1><pre style="font-size:13px">'
        . esc_html( implode( "\n", $result ) )
        . '</pre><p><a href="' . esc_url( admin_url() ) . '">&larr; Dashboard</a></p>'
    );
} );

function tih_seed_all_islands(): array {
    $log = [];

    /* ============================================================
       ISLAND DATA
    ============================================================ */
    $islands_data = [
        [
            'title'   => 'Oshima',
            'slug'    => 'oshima',
            'jp'      => '大島',
            'excerpt' => "Tokyo's largest island — famous for camellia oil, Mihara volcano, and the annual Oshima Tsubaki Festival.",
            'content' => '<p>Oshima (大島) is the largest of the Izu Islands, located 120 km south of central Tokyo and reachable by overnight ferry or a 45-minute flight. It is dominated by Mount Mihara (三原山), an active volcano whose 1986 eruption temporarily evacuated the island\'s entire population of 10,000.</p><p>Today, Oshima is celebrated for two artisanal products above all else: <strong>tsubaki (camellia) oil</strong>, pressed from the abundant wild camellia forests that blanket the island\'s slopes, and the island\'s distinctive <strong>shochu and awamori</strong> tradition. The camellia oil, cold-pressed and unrefined, has been used for centuries in Japanese skincare and hair care, and is now marketed internationally under the J-Beauty umbrella.</p><p>Oshima is also the home of <strong>kusaya</strong>, the intensely flavoured fermented dried fish that defines island gourmet culture across the entire Izu chain.</p>',
            'map'     => 'https://maps.google.com/?q=%E5%A4%A7%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        [
            'title'   => 'Toshima',
            'slug'    => 'toshima',
            'jp'      => '利島',
            'excerpt' => "Japan's camellia oil capital — more than 200,000 camellia trees cover 80% of this tiny circular island.",
            'content' => '<p>Toshima (利島) is a near-perfectly circular volcanic island, home to just 300 people and more than 200,000 camellia trees. It is the undisputed capital of Japanese camellia oil production, with tsubaki oil cultivation forming the backbone of the island economy for centuries.</p><p>The island\'s oil is cold-pressed from hand-harvested camellia seeds and is regarded as the highest-grade in Japan — prized by traditional geisha for hair treatment and increasingly sought by international J-Beauty enthusiasts. GI certification under <em>Toshima Tsubakiyu</em> is currently in progress.</p><p>Toshima has no hotel — visitors stay in a handful of minshuku (family guesthouses), reinforcing the island\'s reputation as a hidden gem that reveals itself only to those who seek it.</p>',
            'map'     => 'https://maps.google.com/?q=%E5%88%A9%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        [
            'title'   => 'Niijima',
            'slug'    => 'niijima',
            'jp'      => '新島',
            'excerpt' => "Home of world-unique Niijima glass — volcanic Koga stone creates an unmistakable olive-green hue found nowhere else on earth.",
            'content' => '<p>Niijima (新島) is a long, narrow island 160 km south of Tokyo, best known among surfers for its Pacific swells — and among craft collectors for <strong>Niijima Glass (新島ガラス)</strong>, one of Japan\'s most distinctive regional art forms.</p><p>The glass is made from <em>Koga stone</em> (抗火石), a volcanic tuff unique to Niijima, which melts at unusually low temperatures and imparts a characteristic smoky olive-green colour to blown glass objects. The island has cultivated a community of glass artists whose work ranges from practical tableware to collector sculptures.</p><p>Beyond glass, Niijima produces a respected barley shochu and is one of the traditional producers of <strong>kusaya</strong> — the island\'s kusaya culture dates back to the Edo period when salt was rationed and islanders developed the fermented brine technique to preserve fish.</p>',
            'map'     => 'https://maps.google.com/?q=%E6%96%B0%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        [
            'title'   => 'Shikinejima',
            'slug'    => 'shikinejima',
            'jp'      => '式根島',
            'excerpt' => "A tiny paradise of natural hot spring sea pools — administratively part of Niijima village, with its own artisanal shochu tradition.",
            'content' => '<p>Shikinejima (式根島) is one of the smallest inhabited islands in the Izu chain, administratively part of Niijima village, situated just 4 km from Niijima\'s southern tip. The island is famous for its natural hot spring pools at the ocean\'s edge — fed by geothermal vents and open 24 hours a day, free of charge.</p><p>With a population of around 600, Shikinejima supports a small but proud artisanal food and spirit tradition. The island shares the kusaya culture of its Niijima neighbour and produces small-batch shochu that rarely reaches mainland markets.</p>',
            'map'     => 'https://maps.google.com/?q=%E5%BC%8F%E6%A0%B9%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        [
            'title'   => 'Kozushima',
            'slug'    => 'kozushima',
            'jp'      => '神津島',
            'excerpt' => "The mythological 'island of the gods' — stunning white sand beaches and a distinctive herbal shochu tradition.",
            'content' => '<p>Kozushima (神津島) takes its name from an ancient myth: the gods of all the Izu Islands gathered here to divide the water of Japan, making it literally the "island of the gods" (神津). The island\'s white sandy beaches and emerald waters are considered among the finest in the Tokyo Islands chain.</p><p>Kozushima\'s signature spirit is <strong>Kozushima Shochu</strong>, a barley-based shochu with a distinctively herbal character attributed to the island\'s unique freshwater springs — the same mythological waters that the gods supposedly divided. Small-batch production means supply to mainland Japan is limited; overseas availability is virtually zero without using Buyee or similar services.</p>',
            'map'     => 'https://maps.google.com/?q=%E7%A5%9E%E6%B4%A5%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        [
            'title'   => 'Miyakejima',
            'slug'    => 'miyakejima',
            'jp'      => '三宅島',
            'excerpt' => "The 'volcanic island of birds' — its 2000 eruption forced a four-year full evacuation; today the caldera trail is one of Japan's most dramatic hikes.",
            'content' => '<p>Miyakejima (三宅島) is defined by Oyama volcano, which erupted catastrophically in 2000, forcing the evacuation of all 3,800 inhabitants for four years. Residents returned in 2005 to find their island transformed — the eruption\'s sulphur dioxide still seeps from the caldera, making gas masks obligatory near the summit, and creating an eerie, otherworldly landscape that has become a major draw for adventurous tourists.</p><p>The island is a paradise for birdwatchers (it is a stopover on the East Asian flyway) and for shochu enthusiasts. <strong>Miyakejima Shochu</strong> is distilled in small quantities and benefits from the island\'s mineral-rich volcanic aquifer. Kusaya production here is considered among the finest in the Izu chain.</p>',
            'map'     => 'https://maps.google.com/?q=%E4%B8%89%E5%AE%85%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        [
            'title'   => 'Mikurajima',
            'slug'    => 'mikurajima',
            'jp'      => '御蔵島',
            'excerpt' => "Japan's dolphin island — a UNESCO reserve where wild bottlenose dolphins swim alongside snorkellers, surrounded by virgin subtropical forest.",
            'content' => '<p>Mikurajima (御蔵島) is one of the most pristine islands in the entire Izu chain — over 80% of its surface is covered by virgin subtropical forest designated as a UNESCO Biosphere Reserve. The island is famous internationally for its resident pod of 150–200 wild bottlenose dolphins, with which tourist snorkelling trips operate from May to September.</p><p>Human population: approximately 300. The island has no convenience stores, no vending machines, and carefully controls visitor numbers. Its camellia oil — pressed from the ancient camellia forest — is produced in tiny quantities and considered by connoisseurs to be among the finest of all Tokyo Island camellia oils.</p>',
            'map'     => 'https://maps.google.com/?q=%E5%BE%A1%E8%94%B5%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        [
            'title'   => 'Hachijojima',
            'slug'    => 'hachijojima',
            'jp'      => '八丈島',
            'excerpt' => "The 'Hawaii of Tokyo' — lush tropical vegetation, world-class shochu distilleries, and the ancestral home of kusaya fermented fish.",
            'content' => '<p>Hachijojima (八丈島) is the largest and most accessible of the remote southern Izu Islands, reachable by daily ANA flights (45 min) or overnight ferry from Tokyo. Its subtropical climate, dramatic volcanic twin-peak landscape, and lush vegetation earn it the nickname "Hawaii of Tokyo."</p><p>The island is the heartland of <strong>Hachijo Shochu (八丈島焼酎)</strong> — a GI-certified spirit distinct from Aogashima\'s Aochu, with major distilleries including Tōkō (東光) and Yamabe. The shochu here uses yellow koji alongside traditional barley, producing a rounder, fruitier profile than the wild-yeast complexity of Aochu.</p><p>Hachijojima is also widely credited as the ancestral home of <strong>kusaya</strong> — the distinctively pungent, intensely umami dried fish fermented in a centuries-old brine that is the island\'s most famous (and polarising) export.</p>',
            'map'     => 'https://maps.google.com/?q=%E5%85%AB%E4%B8%88%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        // Aogashima already exists — skip
        [
            'title'   => 'Chichijima',
            'slug'    => 'chichijima',
            'jp'      => '父島（小笠原）',
            'excerpt' => "The inhabited heart of the UNESCO Ogasawara Islands — 1,000 km from Tokyo, accessible only by a 24-hour ferry, rich in rum and endemic nature.",
            'content' => '<p>Chichijima (父島) is the main inhabited island of the Ogasawara archipelago, a UNESCO Natural World Heritage site 1,000 km south of Tokyo. It is accessible only by the Ogasawara Maru ferry — a 24-hour journey that departs Tokyo approximately once a week, making Chichijima one of the most remote destinations in the Japanese capital.</p><p>The island\'s unique position as a Pacific oceanic island that was never connected to a continental landmass means it supports extraordinary endemic biodiversity, including the Bonin Flying Fox and dozens of endemic bird species.</p><p>Artisanally, Chichijima is known for <strong>Ogasawara Rum</strong> — distilled from locally grown sugarcane — and for a growing craft culture inspired by the island\'s tropical-Pacific character, quite distinct from the volcanic-Japanese aesthetic of the Izu Islands to the north.</p>',
            'map'     => 'https://maps.google.com/?q=%E7%88%B6%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
        [
            'title'   => 'Hahajima',
            'slug'    => 'hahajima',
            'jp'      => '母島（小笠原）',
            'excerpt' => "The wilder sister island of Chichijima — even fewer visitors, extraordinary endemic wildlife, and artisanal lemon and rum products.",
            'content' => '<p>Hahajima (母島) lies 50 km south of Chichijima and is accessible by a small inter-island ferry from Chichijima\'s port. With a permanent population of around 450, it is quieter, wilder, and even more biologically extraordinary than its northern neighbour — offering some of the most pristine hiking and birdwatching in all of Japan.</p><p>Local artisanal products include <strong>Hahajima Lemon Products</strong> — the island\'s lemon groves produce a small-scale harvest of citrus products including lemon jam, dried lemon, and lemon-infused spirits. The island also participates in the small-batch rum culture developing across the Ogasawara archipelago.</p>',
            'map'     => 'https://maps.google.com/?q=%E6%AF%8D%E5%B3%B6%EF%BC%8C%E6%9D%B1%E4%BA%AC%E9%83%BD',
        ],
    ];

    /* ============================================================
       PRODUCT DATA  (one signature product per island × category)
    ============================================================ */
    $products_data = [
        // Spirits
        [
            'title'    => 'Hachijo Shochu Toko — Yellow Koji Barley Spirit (八丈島焼酎 東光)',
            'slug'     => 'hachijo-shochu-toko',
            'island'   => 'hachijojima',
            'category' => 'spirits',
            'jp_kw'    => '八丈島焼酎 東光',
            'price'    => 2400,
            'visual'   => "Dark green or black bottle (720ml)\nLabel: gold foil lettering「東光」on white/cream background\nOften sold in a matching dark gift box\nRound bottle shape typical of Hachijo distilleries",
            'excerpt'  => 'GI-certified Hachijojima shochu from the historic Toko distillery — yellow koji barley with a smooth, rounded Pacific character.',
            'content'  => '<p>Toko (東光) is one of the most celebrated of the Hachijojima shochu distilleries, using <em>yellow koji (黄麹)</em> alongside barley to create a spirit with a rounder, fruitier profile than the wild-yeast intensity of Aogashima\'s Aochu.</p><p>Yellow koji — more commonly used in sake production — is rare in shochu, giving Toko a delicate floral nose and a smoother palate than red or black koji variants. The result is a highly approachable entry point into the world of Tokyo Island spirits.</p><p><strong>GI certified</strong> under <em>Hachijojima Shochu</em> designation.</p>',
        ],
        [
            'title'    => 'Kozushima Shochu — Sacred Spring Barley Spirit (神津島焼酎)',
            'slug'     => 'kozushima-shochu',
            'island'   => 'kozushima',
            'category' => 'spirits',
            'jp_kw'    => '神津島焼酎',
            'price'    => 2600,
            'visual'   => "Clear glass bottle (720ml)\nLabel: white with blue wave motif and kanji「神津島焼酎」\nMay include a small deity or wave graphic",
            'excerpt'  => 'Barley shochu distilled with Kozushima\'s mythological spring water — herbal, mineral, and light.',
            'content'  => '<p>Kozushima Shochu is distilled using the island\'s legendary freshwater springs — the same waters that, according to Shinto mythology, the gods of all the Izu Islands came here to receive. The water\'s mineral profile gives the shochu a distinctive herbal, almost green-tea-like quality that sets it apart from the more intensely volcanic character of Aogashima\'s Aochu.</p>',
        ],
        // Beauty
        [
            'title'    => 'Toshima Tsubaki Oil — Pure Cold-Pressed Camellia (利島椿油)',
            'slug'     => 'toshima-tsubaki-oil',
            'island'   => 'toshima',
            'category' => 'beauty',
            'jp_kw'    => '利島椿油',
            'price'    => 3800,
            'visual'   => "Small amber or dark glass bottle (30ml–100ml)\nLabel: typically ivory/white with pressed camellia flower illustration\nCap: gold or dark metal dropper or stopper\nOften boxed in a white gift box with camellia motif",
            'excerpt'  => 'Cold-pressed from hand-harvested Toshima camellia seeds — the purest single-origin J-Beauty oil in Japan.',
            'content'  => '<p>Toshima Tsubaki Oil is cold-pressed from camellia seeds hand-harvested on Toshima\'s slopes, where over 200,000 camellia trees grow across 80% of the island\'s surface. No heat, solvents, or additives — the oil retains its full complement of oleic acid (82%), which closely mirrors the skin\'s natural sebum, making it uniquely biocompatible.</p><p>Traditional uses: hair oil (prevents split ends, adds shine), face oil (morning and evening), and body oil after bathing. Contemporary J-Beauty brands have adopted it as a hero ingredient in luxury skincare lines.</p>',
        ],
        [
            'title'    => 'Oshima Tsubaki Hair Oil — Classic Island Camellia (大島椿)',
            'slug'     => 'oshima-tsubaki-hair-oil',
            'island'   => 'oshima',
            'category' => 'beauty',
            'jp_kw'    => '大島椿 椿油',
            'price'    => 1200,
            'visual'   => "Iconic blue-and-white cylindrical bottle (60ml)\nLabel: bold kanji「大島椿」with camellia flower graphic\nCap: white flip-top or stopper\nOne of the most recognisable haircare bottles in Japan — widely sold in drugstores",
            'excerpt'  => 'The iconic Japanese hair oil brand — Oshima Tsubaki has been the gold standard of camellia hair treatment since 1927.',
            'content'  => '<p>Oshima Tsubaki (大島椿) is arguably Japan\'s most recognised camellia oil brand, produced from camellia trees on Oshima island since 1927. The blue-and-white bottle is a fixture in Japanese bathrooms and beauty counters nationwide.</p><p>While mass-market compared to single-origin Toshima oil, Oshima Tsubaki remains a pure, unadulterated camellia oil — widely available in Japan and a logical entry-level introduction to the category for overseas buyers.</p>',
        ],
        // Gourmet
        [
            'title'    => 'Hachijojima Kusaya — Ancestral Island Fermented Fish (八丈島くさや)',
            'slug'     => 'hachijojima-kusaya',
            'island'   => 'hachijojima',
            'category' => 'gourmet',
            'jp_kw'    => '八丈島 くさや',
            'price'    => 1800,
            'visual'   => "Vacuum-sealed flat plastic package (typically 100–200g)\nDark dried fish visible through clear packaging\nLabel: red/orange/white with「くさや」in large kanji\nShelf packaging often in a white cardboard sleeve\nStrong aroma even through packaging — handle with care",
            'excerpt'  => 'The ancestral kusaya of Hachijojima — fermented in a 200-year-old brine, grilled until caramelised, intensely umami.',
            'content'  => '<p>Kusaya (くさや) is arguably the most challenging and rewarding flavour in all of Japanese island cuisine. Dried fish — typically flying fish (tobiuo) or mackerel — is marinated in a centuries-old kusaya brine (kusaya-jiru, くさや汁), a concentrated fermented liquid that functions like a living sourdough culture: the older the brine, the more complex the flavour.</p><p>Hachijojima kusaya is considered the original — the island\'s kusaya-jiru culture dates back to the Edo period when salt was taxed and islanders developed the brine as a salt-efficient preservation method. The result is a product of extraordinary umami depth: pungent on the nose (famously described as "blue cheese meets the ocean"), but caramelised, sweet, and complex when grilled.</p>',
        ],
        [
            'title'    => 'Niijima Kusaya — Milder Island Style (新島くさや)',
            'slug'     => 'niijima-kusaya',
            'island'   => 'niijima',
            'category' => 'gourmet',
            'jp_kw'    => '新島 くさや',
            'price'    => 1600,
            'visual'   => "Vacuum-sealed flat plastic package (100–150g)\nLabel: blue/white with「新島くさや」\nDried fish (typically silver-grey) visible through packaging",
            'excerpt'  => 'Niijima kusaya — slightly milder than Hachijojima, with a cleaner fermented note, prized as an introduction to the genre.',
            'content'  => '<p>Niijima Kusaya is produced in the same tradition as Hachijojima but with a slightly different brine culture that produces a marginally milder, cleaner-nosed product — making it the recommended starting point for overseas buyers new to kusaya. When grilled over charcoal, the exterior caramelises to a glossy, lacquer-like finish while the interior remains moist and rich with umami.</p><p>Pair with cold mugi (barley) shochu or cold sake to balance the intensity.</p>',
        ],
        // Craft
        [
            'title'    => 'Niijima Glass Sake Cup — Koga Stone Volcanic Glassware (新島ガラス ぐい呑み)',
            'slug'     => 'niijima-glass-sake-cup',
            'island'   => 'niijima',
            'category' => 'craft',
            'jp_kw'    => '新島ガラス ぐい呑み',
            'price'    => 4500,
            'visual'   => "Small hand-blown cup (guinomi sake cup, approx. 6cm tall)\nDistinctive smoky olive-green colour — unique to Niijima Koga stone glass\nSlightly irregular form (hand-blown, no two identical)\nNo box typically — wrapped in tissue paper\nMay include a card with the glassblower's name",
            'excerpt'  => 'Hand-blown from Niijima\'s unique volcanic Koga stone — the olive-green colour cannot be replicated with any other glass material on earth.',
            'content'  => '<p>Niijima Glass (新島ガラス) is created from <em>Koga stone</em> (抗火石), a volcanic tuff found only on Niijima island. When melted, Koga stone produces a uniquely translucent glass with an unmistakable smoky olive-green hue — a colour that cannot be reproduced with any other silica source in the world.</p><p>This guinomi (sake cup) is hand-blown by a Niijima island glassblower. Because each piece is individually crafted, no two are identical in form, surface texture, or precise colour depth. The cup is designed for sake, shochu on the rocks, or whisky — the earthy volcanic glass character enhancing the mineral notes of island spirits.</p>',
        ],
        [
            'title'    => 'Niijima Glass Vase — Koga Stone Art Object (新島ガラス 花瓶)',
            'slug'     => 'niijima-glass-vase',
            'island'   => 'niijima',
            'category' => 'craft',
            'jp_kw'    => '新島ガラス 花瓶',
            'price'    => 12000,
            'visual'   => "Medium hand-blown vase (approx. 15–20cm tall)\nOlive-green / smoky grey Koga stone glass\nIrregular organic form — sculptural quality\nMay have a slight iridescent surface depending on firing\nUsually presented in tissue paper, sometimes a plain wooden box",
            'excerpt'  => 'A sculptural vase in volcanic Niijima glass — collector art object with the unmistakable Koga stone olive-green colour.',
            'content'  => '<p>This hand-blown vase represents the more sculptural side of Niijima glass craft — an art object as much as a functional vessel. The Koga stone glass\'s olive-green hue shifts in quality depending on the thickness of the glass and the angle of light, making each piece a dynamic visual experience.</p><p>Niijima glass vases are increasingly sought by design collectors in the US and Europe. Supply is severely limited by the island\'s small population of glassblowers and the finite availability of Koga stone.</p>',
        ],
    ];

    /* ============================================================
       STEP 1 — Create / update islands
    ============================================================ */
    $island_id_map = []; // slug → WP post ID

    // Aogashima already exists — fetch its ID
    $aog = get_posts( [
        'post_type' => 'islands', 'name' => 'aogashima',
        'post_status' => 'any', 'numberposts' => 1,
    ] );
    if ( ! empty( $aog ) ) {
        $island_id_map['aogashima'] = $aog[0]->ID;
        $log[] = "[SKIP] Aogashima already exists (ID: {$aog[0]->ID})";
    }

    foreach ( $islands_data as $island ) {
        $existing = get_posts( [
            'post_type' => 'islands', 'name' => $island['slug'],
            'post_status' => 'any', 'numberposts' => 1,
        ] );

        if ( ! empty( $existing ) ) {
            $island_id_map[ $island['slug'] ] = $existing[0]->ID;
            $log[] = "[SKIP] Island already exists: {$island['title']} (ID: {$existing[0]->ID})";
            continue;
        }

        $id = wp_insert_post( [
            'post_type'    => 'islands',
            'post_status'  => 'publish',
            'post_title'   => $island['title'],
            'post_name'    => $island['slug'],
            'post_excerpt' => $island['excerpt'],
            'post_content' => $island['content'],
        ], true );

        if ( is_wp_error( $id ) ) {
            $log[] = "[ERROR] Island {$island['title']}: " . $id->get_error_message();
            continue;
        }

        update_field( 'island_description', $island['excerpt'], $id );
        update_field( 'island_map_link',    $island['map'],    $id );

        $island_id_map[ $island['slug'] ] = $id;
        $log[] = "[OK] Island: {$island['title']} (ID: $id)";
    }

    /* ============================================================
       STEP 2 — Create products and link to islands
    ============================================================ */
    foreach ( $products_data as $product ) {
        $existing = get_posts( [
            'post_type' => 'products', 'name' => $product['slug'],
            'post_status' => 'any', 'numberposts' => 1,
        ] );

        if ( ! empty( $existing ) ) {
            $log[] = "[SKIP] Product already exists: {$product['title']}";
            continue;
        }

        // Resolve term
        $term = get_term_by( 'slug', $product['category'], 'theme_category' );
        if ( ! $term ) {
            $names = [ 'spirits' => 'Spirits', 'beauty' => 'Beauty', 'gourmet' => 'Gourmet', 'craft' => 'Craft' ];
            $ins   = wp_insert_term( $names[ $product['category'] ] ?? ucfirst( $product['category'] ), 'theme_category', [ 'slug' => $product['category'] ] );
            $term_id = is_wp_error( $ins ) ? null : $ins['term_id'];
        } else {
            $term_id = $term->term_id;
        }

        $pid = wp_insert_post( [
            'post_type'    => 'products',
            'post_status'  => 'publish',
            'post_title'   => $product['title'],
            'post_name'    => $product['slug'],
            'post_excerpt' => $product['excerpt'],
            'post_content' => $product['content'],
        ], true );

        if ( is_wp_error( $pid ) ) {
            $log[] = "[ERROR] Product {$product['title']}: " . $pid->get_error_message();
            continue;
        }

        if ( $term_id ) wp_set_post_terms( $pid, [ $term_id ], 'theme_category' );

        $island_id = $island_id_map[ $product['island'] ] ?? null;

        update_field( 'jp_keyword',      $product['jp_kw'],  $pid );
        update_field( 'price_yen',       $product['price'],  $pid );
        update_field( 'visual_id_guide', $product['visual'], $pid );
        update_field( 'buyee_url',       '',                 $pid );

        if ( $island_id ) {
            update_field( 'featured_island', [ $island_id ], $pid );

            // Back-link from island → product
            $cur = get_field( 'related_products', $island_id ) ?: [];
            $cur_ids = array_map( fn($p) => is_object($p) ? $p->ID : (int)$p, $cur );
            if ( ! in_array( $pid, $cur_ids, true ) ) {
                $cur_ids[] = $pid;
                update_field( 'related_products', $cur_ids, $island_id );
            }
        }

        $log[] = "[OK] Product: {$product['title']} (ID: $pid) → island: {$product['island']}";
    }

    /* ============================================================
       STEP 3 — Summary
    ============================================================ */
    $island_count  = wp_count_posts( 'islands' )->publish;
    $product_count = wp_count_posts( 'products' )->publish;
    $log[] = '';
    $log[] = "=== Summary ===";
    $log[] = "Islands  (published): $island_count";
    $log[] = "Products (published): $product_count";

    return $log;
}
