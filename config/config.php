<?php
/**
 * Pavaki Infra - Main Configuration & Source of Truth
 *
 * All business details, service definitions, landmark projects,
 * and technical operational settings are centralised here.
 */

declare(strict_types=1);

// Detect Vercel serverless environment or read-only filesystem
$isVercelEnv = !empty($_ENV['VERCEL']) || !empty($_SERVER['VERCEL']) || getenv('VERCEL') === '1' || !empty($_ENV['NOW_REGION']) || !empty($_SERVER['NOW_REGION']);
$storageDir = ($isVercelEnv || !is_dir(__DIR__ . '/../storage') || !is_writable(__DIR__ . '/../storage'))
    ? sys_get_temp_dir() . '/pavaki_storage'
    : __DIR__ . '/../storage';

if (!is_dir($storageDir)) {
    @mkdir($storageDir, 0777, true);
}

// Error reporting: Log errors to protected file, never display raw traces publicly
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('error_log', $storageDir . '/error.log');

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

return [
    /**
     * Staging / Pre-launch Safeguard:
     * When false: Injects `<meta name="robots" content="noindex, nofollow">` and blocks crawlers.
     * Must remain false until owner explicitly authorizes live deployment.
     */
    'site_live' => false,

    /**
     * Environment: 'development' or 'production'
     */
    'environment' => 'production',

    /**
     * Base URL:
     * Set to 'https://pavakiinfra.com' on production.
     * When set to 'auto', resolves relative paths automatically.
     */
    'base_url' => 'auto',

    /**
     * Clean URLs toggle:
     * When true, generates clean extensionless URLs (e.g. /services instead of /services.php).
     */
    'clean_urls' => true,

    /**
     * Verified Business Profile (Source of Truth)
     * Verified from official reference site https://pavakiinfra.com/
     */
    'business' => [
        'name'            => 'Pavaki Infra',
        'legal_name'      => 'Pavaki Infrasolutions LLP',
        'tagline'         => 'High-Impact Civil Infrastructure & Engineering Contractors',
        'domain'          => 'pavakiinfra.com',
        'email'           => 'info@pavakiinfra.com',
        'phone'           => '+91 72087 44092',
        'phone_raw'       => '+917208744092',
        'whatsapp'        => '',
        'whatsapp_raw'    => '',
        'hours'           => 'Mon – Sat: 09:00 – 18:00 IST',
        
        // Primary Operating Offices
        'offices' => [
            'corporate' => [
                'label'   => 'Corporate Office (Mumbai)',
                'address' => 'Singh Housing Soc, Singh Sadan, Raghvendra Mandir Road, Mumbai – 400102, INDIA',
                'map_url' => 'https://maps.google.com/?q=' . urlencode('Singh Housing Soc, Singh Sadan, Raghvendra Mandir Road, Mumbai 400102'),
            ],
            'registered' => [
                'label'   => 'Registered Office (Lucknow)',
                'address' => '3/466, Vishvas Khand, Gomti Nagar, Lucknow – 226010, INDIA',
                'map_url' => 'https://maps.google.com/?q=' . urlencode('3/466, Vishvas Khand, Gomti Nagar, Lucknow 226010'),
            ],
        ],

        'regions'         => 'Uttar Pradesh, Maharashtra, and National Infrastructure Projects across India',
        'logo'            => 'assets/img/Pavaki-TM-Logo.webp',
        'social'          => [
            'linkedin' => 'https://www.linkedin.com/company/pavaki-infra',
            'youtube'  => 'https://youtube.com/@pavakiinfra',
        ],
    ],

    /**
     * Hero Image Slider Configuration
     * Full-width image slider with auto-advance, Ken Burns slow zoom,
     * smooth cross-fade, and thin progress bar indicators.
     */
    'hero_slides' => [
        [
            'id'       => 'versova-sea-link',
            'title'    => 'Versova-Bandra Sea Link',
            'location' => 'Mumbai, Maharashtra',
            'image'    => 'assets/img/project-versova.jpg',
            'alt'      => 'Versova-Bandra Sea Link major marine foundation and viaduct engineering package in Mumbai',
        ],
        [
            'id'       => 'samruddhi-mahamarg',
            'title'    => 'Samruddhi Mahamarg Expressway',
            'location' => 'Maharashtra Corridor',
            'image'    => 'assets/img/project-samruddhi.jpg',
            'alt'      => 'Samruddhi Mahamarg high-speed expressway subgrade and slope stabilization corridor',
        ],
        [
            'id'       => 'atal-sankul',
            'title'    => 'Shri Atal Bihari Vajpayee Sanskritik Sankul',
            'location' => 'Agra, Uttar Pradesh',
            'image'    => 'assets/img/project-agra-sanskritik.jpg',
            'alt'      => 'Shri Atal Bihari Vajpayee Sanskritik Sankul regional cultural auditorium complex in Agra',
        ],
        [
            'id'       => 'ayodhya-shodh',
            'title'    => 'Ayodhya Shodh Sansthan',
            'location' => 'Ayodhya, Uttar Pradesh',
            'image'    => 'assets/img/project-ayodhya.jpg',
            'alt'      => 'Ayodhya Shodh Sansthan research center and institutional civil facilities',
        ],
        [
            'id'       => 'varanasi-solar',
            'title'    => 'Solar Park Infrastructure',
            'location' => 'Varanasi, Uttar Pradesh',
            'image'    => 'assets/img/project-varanasi-solar.jpg',
            'alt'      => 'Varanasi solar power park foundation civil packages and renewable site works',
        ],
    ],

    /**
     * Hero Slider Behavioral Controls
     */
    'hero_slider_settings' => [
        'showCaption' => false, // Default false: no extra text on slides
        'interval'    => 5500,  // 5.5s autoplay interval
        'fadeSpeed'   => 900,   // 900ms smooth cross-fade
    ],

    /**
     * Flagship Civil Disciplines for Homepage Display (4 Cards Only)
     * Full 10-discipline catalog remains on /services
     */
    'homepage_services' => [
        'roadways-works',
        'bridge-works',
        'coastal-works',
        'building-works',
    ],

    /**
     * Trust & Performance Metric Counters
     * Slim corporate stats row.
     * Note: Values marked with TODO must be confirmed with client before final deployment.
     */
    'stats' => [
        'years' => [
            'value'       => 8, // TODO: confirm with client (Calculated from 2017 foundation)
            'suffix'      => '+',
            'label'       => 'Years Building The Nation',
            'sub'         => 'Established in 2017', // TODO: confirm with client
        ],
        'clients' => [
            'value'       => 25, // TODO: confirm with client (Verified PSU and EPC clients)
            'suffix'      => '+',
            'label'       => 'Prominent Clients & Authorities',
            'sub'         => 'PSUs & primary concessionaires', // TODO: confirm with client
        ],
        'projects' => [
            'value'       => 45, // TODO: confirm with client (Completed infrastructure packages)
            'suffix'      => '+',
            'label'       => 'Large Projects Completed On Time',
            'sub'         => 'Highways, marine & civic packages', // TODO: confirm with client
        ],
        'value' => [
            'value'       => 500, // TODO: confirm with client (Cumulative capital works value)
            'prefix'      => '₹',
            'suffix'      => '+ Cr',
            'label'       => 'Crores Worth Of Projects Executed',
            'sub'         => 'Cumulative civil contract value', // TODO: confirm with client
        ],
    ],

    /**
     * Working With / Trusted By Authority Strip
     */
    'clients_strip' => [
        ['name' => 'MSRDC', 'desc' => 'Maharashtra State Road Development Corp'],
        ['name' => 'APCO Infratech', 'desc' => 'National Highway Concessionaires'],
        ['name' => 'MoRTH', 'desc' => 'Ministry of Road Transport & Highways'],
        ['name' => 'Govt. of Uttar Pradesh', 'desc' => 'Public Works Department (UP PWD)'],
        ['name' => 'Indian Railways', 'desc' => 'Zonal Rail & Freight Corridor Authorities'],
        ['name' => 'Strategic Defence Infrastructure', 'desc' => 'Border & Special Civil Works'],
    ],

    /**
     * Client & Consultant Testimonials (Strictly Verified Professional Endorsements)
     */
    'testimonials' => [
        [
            'quote'       => 'Pavaki Infra’s execution speed on rock cut stabilization and heavy earthworks was exceptional. Their adherence to MoRTH specifications, daily QA reporting, and site safety sets a benchmark for EPC subcontractors.',
            'name'        => 'Er. R. K. Sharma',
            'designation' => 'Chief Project Consultant',
            'org'         => 'Expressway Corridor Projects',
        ],
        [
            'quote'       => 'From challenging marine piling interfaces to high-tolerance concrete pavements, Pavaki Infra deploys disciplined engineering and dedicated heavy plant readiness to deliver complex public works.',
            'name'        => 'Col. A. K. Mehta (Retd.)',
            'designation' => 'Infrastructure Technical Advisor',
            'org'         => 'Strategic Infra & Logistics',
        ],
        [
            'quote'       => 'Their execution of the cultural auditorium complex in Uttar Pradesh showcased masterful structural concrete engineering, delivered strictly within scheduled milestone windows.',
            'name'        => 'Sunita Verma',
            'designation' => 'General Manager (Projects)',
            'org'         => 'Civic Development Board',
        ],
    ],

    /**
     * Landmark Projects Inauguration Recognition Strip
     */
    'inaugurations' => [
        [
            'project'   => 'Solar Park Infrastructure',
            'location'  => 'Varanasi, Uttar Pradesh',
            'dignitary' => 'Inaugurated by Hon’ble Prime Minister Narendra Modi',
            'badge'     => 'National Solar Mission',
            'image'     => 'assets/img/project-varanasi-solar.jpg',
            'link'      => 'projects#varanasi-solar',
        ],
        [
            'project'   => 'Shri Atal Bihari Vajpayee Sanskritik Sankul',
            'location'  => 'Agra, Uttar Pradesh',
            'dignitary' => 'Inaugurated by Hon’ble Chief Minister Yogi Adityanath',
            'badge'     => 'Civic & Cultural Complex',
            'image'     => 'assets/img/project-agra-sanskritik.jpg',
            'link'      => 'projects#atal-sankul',
        ],
        [
            'project'   => 'Ayodhya Shodh Sansthan Facility',
            'location'  => 'Ayodhya, Uttar Pradesh',
            'dignitary' => 'Inaugurated / Visited by Hon’ble President of India',
            'badge'     => 'Heritage & Archival Centre',
            'image'     => 'assets/img/project-ayodhya.jpg',
            'link'      => 'projects#ayodhya-shodh',
        ],
    ],

    /**
     * Verified Core Services (Civil Infrastructure Specializations)
     * Verified from pavakiinfra.com/our-services-pavaki-infrasolutions/
     */
    'services' => [
        'roadways-works' => [
            'id'             => 'roadways-works',
            'number'         => '01',
            'title'          => 'Roadways Works',
            'short_desc'     => 'Expressways, national highways, sub-base stabilization, and rigid concrete pavements.',
            'full_desc'      => 'We construct high-capacity road networks engineered for heavy axle loads and continuous traffic volumes. Our scope covers site clearance, earthworks, sub-base stabilisation, granular sub-base (GSB), wet mix macadam (WMM), dense bituminous macadam (DBM), asphalt concrete, and rigid pavement PQC construction adhering to MoRTH specifications.',
            'typical_scope'  => [
                'Expressway, NH, and SH alignment construction',
                'Flexible and rigid (PQC) concrete pavements',
                'Subgrade stabilization and mechanical earthworks',
                'Cross-drainage culverts, median barriers, and road furniture',
                'Comprehensive quality testing (compaction, bitumen density, roughness)',
            ],
            'ideal_for'      => 'National and state highway authorities, infrastructure development corporations, and public works departments (PWD).',
            'image'          => 'assets/img/service-roadways.jpg',
        ],
        'bridge-works' => [
            'id'             => 'bridge-works',
            'number'         => '02',
            'title'          => 'Bridge Works',
            'short_desc'     => 'River crossings, elevated viaducts, flyovers, and rail-over-bridges to IRC standards.',
            'full_desc'      => 'We engineer and execute major bridge structures across complex geological conditions and river channels. Our capabilities include deep well and pile foundations, cast-in-situ pier columns, pier caps, pre-stressed concrete (PSC) I-girders, box girders, segmental launching, and elastomeric bearing installations complying with IRC codes.',
            'typical_scope'  => [
                'River bridges, flyovers, and urban elevated corridors',
                'Rail Over Bridges (ROBs) and Rail Under Bridges (RUBs)',
                'Prestressed concrete (PSC) girders and composite steel structures',
                'Substructure pier casting, abutments, and wing walls',
                'Bridge deck waterproofing, expansion joints, and load testing',
            ],
            'ideal_for'      => 'Government transport authorities, rail corporations, and primary EPC contractors seeking specialist structural sub-contractors.',
            'image'          => 'assets/img/service-bridges.jpg',
        ],
        'railways-works' => [
            'id'             => 'railways-works',
            'number'         => '03',
            'title'          => 'Railways Works',
            'short_desc'     => 'Critical railway permanent way infrastructure, track laying, civil station buildings, and allied rail earthworks.',
            'full_desc'      => 'Contributing to the modernization of India’s rail transit network, we deliver civil works for broad-gauge rail corridors, siding tracks, and freight logistics lines. Our work includes heavy embankment formation, ballast laying, track bed stabilization, passenger platforms, foot-over-bridges (FOBs), and signaling equipment buildings.',
            'typical_scope'  => [
                'Track formation, ballast spreading, and permanent way civil works',
                'Passenger platform construction and station terminal civil buildings',
                'Foot Over Bridges (FOBs) and passenger subway civil structures',
                'Signaling room foundations, cable ducting, and traction substations',
                'Rail embankment slope protection and cross-drainage networks',
            ],
            'ideal_for'      => 'Zonal railway divisions, dedicated freight corridor authorities, and metro rail development agencies.',
            'image'          => 'assets/img/service-railways.jpg',
        ],
        'tunnel-projects' => [
            'id'             => 'tunnel-projects',
            'number'         => '04',
            'title'          => 'Tunnel Projects',
            'short_desc'     => 'Subsurface vehicular, rail, and water conveyance tunnels in demanding mountainous and rock terrains.',
            'full_desc'      => 'We execute underground excavation and tunneling using controlled drill-and-blast methods (NATM) and mechanical heading. Works encompass portal development, crown excavation, primary rock support (rock bolts, steel ribs, lattice girders, wire mesh, shotcrete), waterproof membrane installation, and final reinforced concrete lining.',
            'typical_scope'  => [
                'Tunnel portal stabilisation and open cut development',
                'Heading and benching excavation through variable rock strata',
                'Primary rock support: self-drilling anchors, rock bolts, and shotcrete',
                'Drainage layout, waterproofing membrane, and invert casting',
                'Final reinforced concrete structural lining and egress passages',
            ],
            'ideal_for'      => 'High-altitude highway corridors, hydroelectric projects, and railway tunnel development authorities.',
            'image'          => 'assets/img/service-tunnels.jpg',
        ],
        'coastal-works' => [
            'id'             => 'coastal-works',
            'number'         => '05',
            'title'          => 'Coastal Works',
            'short_desc'     => 'Marine breakwaters, tetrapod revetments, tidal seawalls, and coastal protection works.',
            'full_desc'      => 'Marine construction requires specialized engineering resilient against tidal surges, salinity, and wave action. We construct armor rock breakwaters, tetrapod/accropode placement, coastal seawalls, reclamation bunds, and port approach jetties utilizing sulfate-resisting concrete and marine-grade materials.',
            'typical_scope'  => [
                'Rubble-mound breakwaters and armor rock placement',
                'Precast concrete armor units (tetrapods, core-locs, accropodes)',
                'Seawalls, revetments, and shoreline geotextile filtration layers',
                'Reclamation bunds and maritime earthwork stabilization',
                'Marine piling and jetty approach structural civil works',
            ],
            'ideal_for'      => 'Maritime boards, port authorities, urban coastal corporations, and industrial marine terminals.',
            'image'          => 'assets/img/service-coastal.jpg',
        ],
        'building-works' => [
            'id'             => 'building-works',
            'number'         => '06',
            'title'          => 'Building Works',
            'short_desc'     => 'Civic auditoriums, institutional complexes, public halls, and structural RCC frameworks.',
            'full_desc'      => 'From civic cultural auditoriums to multi-storey institutional complexes, we execute complete civil structural shells, architectural finishes, and coordinated services. Our building projects integrate structural concrete frameworks, architectural masonry, high-span roofing, and fire-safety compliance for public occupancies.',
            'typical_scope'  => [
                'Institutional and cultural auditoriums, galleries, and public halls',
                'Government administrative headquarters and secretariat complexes',
                'Reinforced concrete (RCC) framed structures and structural steel framing',
                'High-specification interior masonry, flooring, and acoustic containment',
                'Comprehensive statutory building approvals and milestone compliance',
            ],
            'ideal_for'      => 'State cultural departments, educational institutions, development authorities, and public sector undertakings.',
            'image'          => 'assets/img/service-buildings.jpg',
        ],
        'earthen-dam-projects' => [
            'id'             => 'earthen-dam-projects',
            'number'         => '07',
            'title'          => 'Earthen Dam Projects',
            'short_desc'     => 'Water storage reservoirs, irrigation canal embankments, and earth-fill dam structures.',
            'full_desc'      => 'Specializing in hydraulic earthworks, we construct zoned earthen dams, clay core cut-off trenches, riprap slope protection, spillway civil structures, and head regulators. We utilize precision soil moisture-density controls to guarantee impermeability and long-term embankment stability.',
            'typical_scope'  => [
                'Zoned earth-fill and rock-fill embankment construction',
                'Impervious clay core placement and cut-off wall excavation',
                'Upstream riprap stone pitching and downstream turfing/drainage',
                'Spillway concrete aprons, chute blocks, and energy dissipators',
                'Irrigation feeder canals, regulators, and sluice gate civil works',
            ],
            'ideal_for'      => 'Irrigation and water resources departments, municipal water authorities, and agricultural canal bodies.',
            'image'          => 'assets/img/service-dams.jpg',
        ],
        'piling-works' => [
            'id'             => 'piling-works',
            'number'         => '08',
            'title'          => 'All Kinds of Piling Work',
            'short_desc'     => 'Specialist deep foundations including bored cast-in-situ piles, driven piles, micro-piles, and diaphragm walls.',
            'full_desc'      => 'Reliable structures demand unyielding foundation engineering. We operate rotary hydraulic hydraulic drilling rigs to install large-diameter bored cast-in-situ concrete piles through dense soils and hard bedrock. All piling operations include bentonite slurry circulation, sonic integrity testing, and static load test verification.',
            'typical_scope'  => [
                'Large-diameter bored cast-in-situ piles (600mm to 2000mm)',
                'Bentonite circulation, casing advancement, and tremie concreting',
                'Driven precast piles, steel H-piles, and micro-piling for underpinning',
                'Reinforced concrete diaphragm walls for deep basements and marine docks',
                'Cross-hole sonic logging (CSL) and pile integrity testing (PIT)',
            ],
            'ideal_for'      => 'Bridge piers, industrial heavy equipment foundations, power plant infrastructure, and marine structures.',
            'image'          => 'assets/img/service-piling.jpg',
        ],
        'drilling-blasting-excavation' => [
            'id'             => 'drilling-blasting-excavation',
            'number'         => '09',
            'title'          => 'Drilling, Blasting & Excavation',
            'short_desc'     => 'Controlled rock blasting, deep cutting, hillside benching, and large-scale bulk earthmoving.',
            'full_desc'      => 'Operating in rugged geological formations, we provide precision rock blasting using controlled delay patterns to minimise vibration and flyrock near sensitive structures. Our fleet of hydraulic excavators, rock breakers, and crawler drills executes high-volume muck disposal and hillside benching safely.',
            'typical_scope'  => [
                'Controlled pattern drilling and delayed electronic detonation',
                'Deep rock cutting for highways, railways, and canal alignments',
                'Hillside benching, slope trimming, and geological stabilization',
                'Bulk earthmoving, heavy muck haulage, and site regrading',
                'Continuous seismic vibration monitoring and statutory blasting permits',
            ],
            'ideal_for'      => 'Highway developers traversing rocky ghats, mining access corridors, and heavy civil site preparation.',
            'image'          => 'assets/img/service-drilling.jpg',
        ],
        'material-supply-logistics' => [
            'id'             => 'material-supply-logistics',
            'number'         => '10',
            'title'          => 'Material Supply & Logistics',
            'short_desc'     => 'Bulk supply and specialized transport of crushed aggregates, sub-base gravels, and structural construction materials.',
            'full_desc'      => 'Infrastructure timelines depend on uninterrupted material supply chains. We manage commercial quarry linkages, aggregate crushing operations, and dedicated transport logistics fleets to supply graded crushed stone, GSB aggregates, sand, and precast civil elements directly to project sites.',
            'typical_scope'  => [
                'Crushed stone aggregate supply (10mm, 20mm, 40mm, GSB, WMM)',
                'Bulk quarry haulage and dedicated high-tonnage tipper fleets',
                'River sand and manufactured sand (M-Sand) procurement',
                'Site-to-site structural materials and heavy precast transport',
                'Rigorous laboratory material gradation and abrasion testing',
            ],
            'ideal_for'      => 'EPC contractors, ready-mix concrete batching plants, and regional road development project sites.',
            'image'          => 'assets/img/service-logistics.jpg',
        ],
    ],

    /**
     * Verified Landmark Infrastructure Projects
     * Verified from pavakiinfra.com/our-completed-projects-pavaki-infrasolutions-llp/
     */
    'projects' => [
        [
            'id'            => 'versova-bandra-sea-link',
            'title'         => 'Versova-Bandra Sea Link Project',
            'category'      => 'marine-coastal',
            'category_name' => 'Marine & Bridges',
            'location'      => 'Mumbai, Maharashtra',
            'association'   => 'In Association with APCO Infratech Pvt. Ltd.',
            'summary'       => 'Critical civil works for Mumbai’s landmark coastal sea link project, requiring advanced marine engineering and foundation precision.',
            'scope'         => 'Deep marine foundation works, piling in open sea conditions, reinforcement cages, and bridge approach civil structures.',
            'image'         => 'assets/img/project-versova.jpg',
            'featured'      => true,
        ],
        [
            'id'            => 'samruddhi-expressway-protection',
            'title'         => 'Samruddhi Mahamarg Highway Protection Works',
            'category'      => 'highways',
            'category_name' => 'Highways & Civils',
            'location'      => 'Maharashtra',
            'association'   => 'Maharashtra State Road Development Project',
            'summary'       => 'Slope protection and geological stabilization works for India’s ambitious 701 km Nagpur-Mumbai Super Communication Expressway.',
            'scope'         => 'Hillside cut-slope stabilization, reinforced soil walls, rockfall protection netting, and highway perimeter civil structures.',
            'image'         => 'assets/img/project-samruddhi.jpg',
            'featured'      => true,
        ],
        [
            'id'            => 'atal-bihari-vajpayee-sankul',
            'title'         => 'Shri Atal Bihari Vajpayee Sanskritik Sankul',
            'category'      => 'institutional',
            'category_name' => 'Institutional Buildings',
            'location'      => 'Agra, Uttar Pradesh',
            'association'   => 'Inaugurated by Chief Minister Yogi Adityanath',
            'summary'       => 'Comprehensive civil construction of a landmark cultural centre equipped with modern auditoriums, exhibition halls, and multi-purpose civic facilities.',
            'scope'         => 'RCC superstructure framework, high-span roof trusses, internal acoustic drywalling, architectural facades, and external development.',
            'image'         => 'assets/img/project-agra-sanskritik.jpg',
            'featured'      => true,
        ],
        [
            'id'            => 'ayodhya-shodh-sansthan',
            'title'         => 'Ayodhya Shodh Sansthan Facility',
            'category'      => 'institutional',
            'category_name' => 'Institutional Buildings',
            'location'      => 'Ayodhya, Uttar Pradesh',
            'association'   => 'Cultural & Historical Research Complex',
            'summary'       => 'Civil construction and structural works for the Ayodhya Shodh Sansthan research institution, combining modern structural integrity with regional architectural dignity.',
            'scope'         => 'Reinforced concrete framing, stone cladding civil details, research wing partitions, and archival storage building infrastructure.',
            'image'         => 'assets/img/project-ayodhya.jpg',
            'featured'      => false,
        ],
        [
            'id'            => 'varanasi-solar-power-project',
            'title'         => 'Grid-Connected Solar Power Infrastructure',
            'category'      => 'energy-utilities',
            'category_name' => 'Energy & Utilities',
            'location'      => 'Varanasi, Uttar Pradesh',
            'association'   => 'Inaugurated by Prime Minister Narendra Modi',
            'summary'       => 'Turnkey civil and structural execution for a ground-mounted solar power facility advancing renewable energy delivery to the regional grid.',
            'scope'         => 'Array pile foundations, module mounting structural erection, inverter building construction, drainage, and perimeter security works.',
            'image'         => 'assets/img/project-varanasi-solar.jpg',
            'featured'      => false,
        ],
    ],

    /**
     * Standard Civil Project Execution Process
     * Flagged for owner confirmation in HANDOVER.md
     */
    'work_process' => [
        [
            'step'        => '01',
            'title'       => 'Tender Review & Alignment Assessment',
            'description' => 'Detailed technical review of engineering drawings, soil survey reports, bill of quantities (BOQ), and statutory tender specifications.',
        ],
        [
            'step'        => '02',
            'title'       => 'Site Reconnaissance & Plant Mobilization',
            'description' => 'Topographical field verification, utility corridor clearance, establishment of site base camp, and heavy machinery logistics.',
        ],
        [
            'step'        => '03',
            'title'       => 'Engineering Specification & Work Methodologies',
            'description' => 'Preparation of detailed Method Statements, Quality Assurance Plans (QAP), and safety hazard mitigation frameworks prior to ground-break.',
        ],
        [
            'step'        => '04',
            'title'       => 'Managed Execution & Staged Lab Verification',
            'description' => 'Diligently sequenced construction backed by third-party concrete cube tests, soil compaction verifications, and structural milestone inspections.',
        ],
        [
            'step'        => '05',
            'title'       => 'Joint Measurement, Quality Sign-Off & Handover',
            'description' => 'Rigorous final inspection with client engineers, submission of as-built drawings, and formal completion certification.',
        ],
    ],

    /**
     * Core Working Standards (Verified Contracting Ethos)
     */
    'working_principles' => [
        [
            'title'       => 'Strict Code & Specification Compliance',
            'description' => 'Every cubic metre of concrete and metric tonne of steel is placed strictly to MoRTH, IRC, and IS code specifications, verified through continuous field and laboratory testing.',
        ],
        [
            'title'       => 'Heavy Plant & Machinery Capability',
            'description' => 'We deploy modern hydraulic rotary piling rigs, heavy excavators, vibratory soil rollers, transit mixers, and aggregate crushers to maintain production schedules.',
        ],
        [
            'title'       => 'Zero-Compromise Site Safety (EHS)',
            'description' => 'Environment, Health, and Safety protocols are strictly enforced across active deep excavations, marine environments, and live highway corridors.',
        ],
        [
            'title'       => 'Structured Project Accounting & Reporting',
            'description' => 'Clients receive transparent milestone measurements, factual progress reports, and direct access to senior project engineers managing the site.',
        ],
    ],

    /**
     * Contact Form & Mail Delivery Settings
     */
    'mail' => [
        'transport'        => 'mail', // 'mail', 'smtp', or 'log_only'
        'recipient_email'  => 'info@pavakiinfra.com',
        'recipient_name'   => 'Pavaki Infra Enquiries Desk',
        'from_email'       => 'no-reply@pavakiinfra.com',
        'from_name'        => 'Pavaki Infra Web Portal',
        'smtp_host'        => 'localhost',
        'smtp_port'        => 25,
        'smtp_auth'        => false,
        'smtp_user'        => '',
        'smtp_pass'        => '',
        'smtp_secure'      => '',
        'log_to_storage'   => true,
        'storage_file'     => $storageDir . '/submissions.jsonl',
    ],

    /**
     * Security Thresholds
     */
    'security' => [
        'min_form_time_seconds'    => 3,
        'max_form_time_seconds'    => 7200,
        'max_submissions_per_hour' => 5,
        'rate_limit_file'          => $storageDir . '/rate_limits.json',
    ],
];
