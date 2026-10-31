# Pavaki Infra - Asset Audit & Image Slot Registry (`MISSING_ASSETS.md`)

This document catalogs every image slot across the **Pavaki Infra** corporate platform (`pavakiinfra.com` rebuild), documenting current file mappings, dimensions, aspect ratios, and instructions for client replacement.

---

## 1. Homepage Image Slot Inventory

| Slot ID | Current Asset Path | Purpose / Landmark Package | Recommended Dimensions | Status |
| :--- | :--- | :--- | :--- | :--- |
| **BRAND_LOGO** | `assets/img/Pavaki-TM-Logo.webp` | Primary Header & Footer Brand Identity | 400x120 px (transparent) | **Active Verified** |
| **HERO_SLIDE_1** | `assets/img/project-versova.jpg` | Versova-Bandra Sea Link (Mumbai) | 1920x1080 px (16:9) | **Active Client Photo** |
| **HERO_SLIDE_2** | `assets/img/project-samruddhi.jpg` | Samruddhi Mahamarg Expressway (MH) | 1920x1080 px (16:9) | **Active Client Photo** |
| **HERO_SLIDE_3** | `assets/img/project-agra-sanskritik.jpg`| Atal Bihari Vajpayee Sankul (Agra, UP)| 1920x1080 px (16:9) | **Active Civil Photo** |
| **HERO_SLIDE_4** | `assets/img/project-ayodhya.jpg` | Ayodhya Shodh Sansthan Facility (UP) | 1920x1080 px (16:9) | **Active Civil Photo** |
| **HERO_SLIDE_5** | `assets/img/project-varanasi-solar.jpg`| Grid-Connected Solar Park (Varanasi)| 1920x1080 px (16:9) | **Active Civil Photo** |
| **SERVICE_ROAD** | `assets/img/service-roadways.jpg` | Roadways Works Card | 900x560 px (16:10) | **Active Verified** |
| **SERVICE_BRIDGE**| `assets/img/service-bridges.jpg` | Bridge Works Card | 900x560 px (16:10) | **Active Verified** |
| **SERVICE_COAST** | `assets/img/service-coastal.jpg` | Coastal Works Card | 900x560 px (16:10) | **Active Verified** |
| **SERVICE_BUILD** | `assets/img/service-buildings.jpg`| Building Works Card | 900x560 px (16:10) | **Active Verified** |
| **INTRO_PRIMARY** | `assets/img/service-bridges.jpg` | Company Intro (Bridge Viaduct Structure) | 1200x900 px (4:3) | **Active Verified** |
| **INTRO_OVERLAP** | `assets/img/service-piling.jpg` | Company Intro (Rotary Piling Plant) | 600x400 px (3:2) | **Active Verified** |
| **MAP_THUMB_1** | `assets/img/project-versova.jpg` | India Map Thumbnail: Sea Link | 400x300 px (4:3) | **Active Client Photo** |
| **MAP_THUMB_2** | `assets/img/project-samruddhi.jpg` | India Map Thumbnail: Expressway | 400x300 px (4:3) | **Active Client Photo** |
| **MAP_THUMB_3** | `assets/img/project-agra-sanskritik.jpg`| India Map Thumbnail: Sankul | 400x300 px (4:3) | **Active Civil Photo** |
| **STATS_BG** | `assets/img/about-corporate.jpg` | Stats Blueprint Band Texture (8% Lum) | 1920x600 px | **Active Verified** |
| **SAFETY_HERO** | `assets/img/safety-worker.jpg` | Safety First: PPE Field Engineer | 800x960 px (4:5) | **Active Verified** |
| **INAUG_1** | `assets/img/project-varanasi-solar.jpg`| Inauguration: Solar Park (PM Modi) | 800x500 px (16:10) | **Active Civil Photo** |
| **INAUG_2** | `assets/img/project-agra-sanskritik.jpg`| Inauguration: Sanskritik Sankul (CM Yogi)| 800x500 px (16:10) | **Active Civil Photo** |
| **INAUG_3** | `assets/img/project-ayodhya.jpg` | Inauguration: Ayodhya Shodh (President)| 800x500 px (16:10) | **Active Civil Photo** |
| **CONTACT_HERO** | `assets/img/contact-bridge.jpg` | Contact Left Pane: Bridge Piers & Plant| 900x1125 px (4:5) | **Active Verified** |

---

## 2. Additional Secondary Discipline Image Slots (Used on `/services.php`)

| Discipline | Current Asset | Recommended Size | Status |
| :--- | :--- | :--- | :--- |
| **Railways Works** | `assets/img/service-railways.jpg` | 900x600 px | Active |
| **Tunnel Projects** | `assets/img/service-tunnels.jpg` | 900x600 px | Active |
| **Earthen Dam Projects** | `assets/img/service-dams.jpg` | 900x600 px | Active |
| **Piling Works** | `assets/img/service-piling.jpg` | 900x600 px | Active |
| **Drilling, Blasting & Excavation** | `assets/img/service-drilling.jpg` | 900x600 px | Active |
| **Material Supply & Logistics** | `assets/img/service-logistics.jpg` | 900x600 px | Active |

---

## 3. High-Priority Client Photography Replacements Requested

When high-resolution original site photography is supplied by the client, drop the files directly into `assets/img/` matching the filenames below:

1. **`assets/img/project-agra-sanskritik.jpg`**:
   - High-resolution photograph of the completed **Shri Atal Bihari Vajpayee Sanskritik Sankul** in Agra, UP (showing auditorium exterior facade or stage interior).
2. **`assets/img/project-ayodhya.jpg`**:
   - High-resolution site photograph of the completed **Ayodhya Shodh Sansthan** research complex in Ayodhya, UP.
3. **`assets/img/project-varanasi-solar.jpg`**:
   - High-resolution aerial or site photograph of the **Varanasi Grid-Connected Solar Power Park** foundation structures.

---

## 4. Visual & Image Treatment Guidelines
- **Color Temperature:** Warm industrial corporate grade (+3% warm amber tone, subtle contrast enhancement).
- **Corner Radius:** Standardized `4px` (`border-radius: 4px; overflow: hidden;`).
- **File Format:** High-efficiency WebP or progressive JPG (`80-85%` quality).
- **Aspect Ratios:**
  - Hero Slider: Full viewport cover (`calc(100vh - 74px)`)
  - Service Cards: `16:10`
  - About Media: Primary `4:3` with `16:10` overlap badge
  - Safety Media: `4:5` portrait
  - Inauguration Tiles: `16:10`
  - Contact Media: `4:5` portrait
