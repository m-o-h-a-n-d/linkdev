# Handball Hub - Front-End (HTML + CSS + JS)

## هيكل الفولدرز

```
handball-hub/
├── css/
│   └── main.css              ← كل الـ CSS
├── js/
│   └── main.js               ← كل الـ JavaScript
├── images/                   ← مجلد الصور (جاهز)
├── views/
│   ├── layouts/
│   │   ├── head.html         ← جزئية الـ head (title + fonts + css)
│   │   └── bottom.html       ← جزئية الـ bottom (footer + js)
│   ├── partials/
│   │   ├── navbar.html       ← Navbar
│   │   └── footer.html       ← Footer
│   ├── pages/
│   │   └── home.html         ← الصفحة الرئيسية
│   ├── matches/
│   │   └── index.html        ← صفحة المباريات
│   ├── teams/
│   │   └── index.html        ← صفحة الفرق
│   ├── auth/
│   │   └── signin.html       ← صفحة Sign In
│   └── competitions/
│       ├── national-league.html
│       ├── delta-cup.html
│       └── winter-shield.html
├── index.html                ← ملف الـ root (بيشتغل مباشرة)
└── README.md
```

## كيفية التحويل لـ Blade في Laravel

### 1. انسخي الـ CSS والـ JS
```bash
cp css/main.css your-laravel-project/public/css/
cp js/main.js your-laravel-project/public/js/
```

### 2. حطّي الـ Views في مجلد views
كل ملف `.html` بيتحول لـ `.blade.php` بنفس الشكل
مثلاً: `views/pages/home.html` → `resources/views/pages/home.blade.php`

### 3. استبدلي الـ relative paths بالـ Laravel helpers
```
"../../css/main.css"     →  "{{ asset('css/main.css') }}"
"../../js/main.js"       →  "{{ asset('js/main.js') }}"
"../../index.html"       →  "{{ url('/') }}"
"../competitions/..."    →  "{{ url('/competitions/...') }}"
```

### 4. استخدمي @extends + @section
مثال للـ Home Page:
```blade
@extends('layouts.app')

@section('title', 'Handball Hub — Live Scores')

@section('content')
  {{-- محتوى الصفحة هنا --}}
@endsection
```

### 5. استخدمي @include للـ partials
```blade
@include('partials.navbar')
@include('partials.footer')
```

## الصفحات (6 صفحات)
1. **Home** - Hero + Live Score + Competitions + Next Up
2. **Matches** - Match Centre مع Filter Tabs (All/Live/Upcoming/Results)
3. **Teams** - 8 فرق بـ stats كاملة
4. **Auth** - Sign In / Sign Up مع Google
5. **National League** - Standings (Group A & B) + Fixtures
6. **Delta Cup** + **Winter Shield** - Competition pages

## مميزات التصميم
- **Responsive** - يعمل على الموبايل والديسكتوب
- **Dark Theme** - تصميم داكن بألوان برتقالية
- **Filter System** - فلتر المباريات (All/Live/Upcoming/Results)
- **Auth Tabs** - تبديل بين Sign In و Sign Up
- **Live Indicators** - مؤشرات حية للمباريات الجارية مع animation
