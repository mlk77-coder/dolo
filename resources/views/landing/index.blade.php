@extends('layouts.landing')

@section('title', 'تطبيق دولو - احصل على أفضل الصفقات')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg text-white py-20 relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center justify-between">
            <!-- Text Content -->
            <div class="lg:w-1/2 text-center lg:text-right mb-10 lg:mb-0">
                <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    اكتشف أفضل العروض<br>
                    <span class="text-yellow-300">مع تطبيق دولو</span>
                </h1>
                <p class="text-xl mb-8 text-gray-100 leading-relaxed">
                    وفّر المال واحصل على صفقات مذهلة من أفضل التجار والمتاجر في مدينتك
                </p>
                
                <!-- Download Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="https://apps.apple.com/app/dolo" target="_blank" class="bg-black hover:bg-gray-900 text-white px-8 py-4 rounded-xl flex items-center justify-center gap-3 transition transform hover:scale-105">
                        <i class="fab fa-apple text-3xl"></i>
                        <div class="text-right">
                            <div class="text-xs">حمّل من</div>
                            <div class="text-lg font-bold">App Store</div>
                        </div>
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=com.dolo.app" target="_blank" class="bg-white hover:bg-gray-100 text-gray-900 px-8 py-4 rounded-xl flex items-center justify-center gap-3 transition transform hover:scale-105">
                        <i class="fab fa-google-play text-3xl text-green-600"></i>
                        <div class="text-right">
                            <div class="text-xs">حمّل من</div>
                            <div class="text-lg font-bold">Google Play</div>
                        </div>
                    </a>
                    <a href="{{ route('landing.download-apk') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-4 rounded-xl flex items-center justify-center gap-3 transition transform hover:scale-105">
                        <i class="fab fa-android text-3xl"></i>
                        <div class="text-right">
                            <div class="text-xs">تحميل مباشر</div>
                            <div class="text-lg font-bold">APK للأندرويد</div>
                        </div>
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="flex gap-8 mt-12 justify-center lg:justify-start">
                    <div>
                        <div class="text-3xl font-bold">1000+</div>
                        <div class="text-sm text-gray-200">عرض حصري</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">500+</div>
                        <div class="text-sm text-gray-200">تاجر موثوق</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">10K+</div>
                        <div class="text-sm text-gray-200">مستخدم سعيد</div>
                    </div>
                </div>
            </div>
            
            <!-- Phone Mockup -->
            <div class="lg:w-1/2 flex justify-center">
                <div class="relative floating">
                    <div class="w-80 h-[600px] bg-gray-900 rounded-[50px] p-3 shadow-2xl">
                        <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 rounded-[40px] flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-mobile-alt text-8xl mb-4"></i>
                                <p class="text-xl font-bold">تطبيق دولو</p>
                            </div>
                        </div>
                    </div>
                    <!-- Floating Elements -->
                    <div class="absolute -top-10 -right-10 bg-yellow-400 rounded-full p-4 shadow-lg">
                        <i class="fas fa-percent text-3xl text-white"></i>
                    </div>
                    <div class="absolute -bottom-10 -left-10 bg-green-400 rounded-full p-4 shadow-lg">
                        <i class="fas fa-gift text-3xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Shape -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50" id="features">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">
                <span class="gradient-text">مميزات التطبيق</span>
            </h2>
            <p class="text-xl text-gray-600">اكتشف كل ما يقدمه تطبيقنا لك</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-tags text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">عروض حصرية</h3>
                <p class="text-gray-600 leading-relaxed">
                    احصل على خصومات تصل إلى 70% على منتجات وخدمات متنوعة من أفضل التجار
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-map-marker-alt text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">عروض قريبة منك</h3>
                <p class="text-gray-600 leading-relaxed">
                    اكتشف العروض والصفقات في منطقتك وتسوق من المتاجر القريبة منك
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-bell text-3xl text-green-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">إشعارات فورية</h3>
                <p class="text-gray-600 leading-relaxed">
                    احصل على تنبيهات فورية عند إضافة عروض جديدة لا تفوت أي صفقة
                </p>
            </div>
            
            <!-- Feature 4 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-shopping-cart text-3xl text-yellow-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">طلب سهل وسريع</h3>
                <p class="text-gray-600 leading-relaxed">
                    اطلب العروض بضغطة زر واحدة واستلمها في أسرع وقت ممكن
                </p>
            </div>
            
            <!-- Feature 5 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-star text-3xl text-red-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">تقييمات موثوقة</h3>
                <p class="text-gray-600 leading-relaxed">
                    اقرأ تقييمات المستخدمين الحقيقية قبل الشراء واتخذ القرار الصحيح
                </p>
            </div>
            
            <!-- Feature 6 -->
            <div class="feature-card bg-white p-8 rounded-2xl shadow-lg">
                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-3xl text-indigo-600"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">دفع آمن</h3>
                <p class="text-gray-600 leading-relaxed">
                    نظام دفع آمن ومشفر لحماية معلوماتك المالية بأعلى معايير الأمان
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">
                <span class="gradient-text">كيف يعمل التطبيق؟</span>
            </h2>
            <p class="text-xl text-gray-600">ثلاث خطوات بسيطة للحصول على أفضل العروض</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-12">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-4xl font-bold shadow-lg">
                    1
                </div>
                <h3 class="text-2xl font-bold mb-4">حمّل التطبيق</h3>
                <p class="text-gray-600 leading-relaxed">
                    قم بتحميل التطبيق من App Store أو Google Play وأنشئ حسابك المجاني
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-4xl font-bold shadow-lg">
                    2
                </div>
                <h3 class="text-2xl font-bold mb-4">تصفح العروض</h3>
                <p class="text-gray-600 leading-relaxed">
                    استعرض مئات العروض والخصومات الحصرية من مختلف الفئات والتجار
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-4xl font-bold shadow-lg">
                    3
                </div>
                <h3 class="text-2xl font-bold mb-4">اطلب ووفّر</h3>
                <p class="text-gray-600 leading-relaxed">
                    اطلب العرض الذي يعجبك واستمتع بالتوفير والخصومات المذهلة
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 gradient-bg text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl lg:text-5xl font-bold mb-6">
            جاهز للبدء في التوفير؟
        </h2>
        <p class="text-xl mb-10 text-gray-100">
            حمّل التطبيق الآن واحصل على عروض حصرية فور التسجيل
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://apps.apple.com/app/dolo" target="_blank" class="bg-black hover:bg-gray-900 text-white px-10 py-5 rounded-xl flex items-center justify-center gap-3 transition transform hover:scale-105 text-lg">
                <i class="fab fa-apple text-4xl"></i>
                <div class="text-right">
                    <div class="text-sm">حمّل من</div>
                    <div class="text-xl font-bold">App Store</div>
                </div>
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.dolo.app" target="_blank" class="bg-white hover:bg-gray-100 text-gray-900 px-10 py-5 rounded-xl flex items-center justify-center gap-3 transition transform hover:scale-105 text-lg">
                <i class="fab fa-google-play text-4xl text-green-600"></i>
                <div class="text-right">
                    <div class="text-sm">حمّل من</div>
                    <div class="text-xl font-bold">Google Play</div>
                </div>
            </a>
            <a href="{{ route('landing.download-apk') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-10 py-5 rounded-xl flex items-center justify-center gap-3 transition transform hover:scale-105 text-lg">
                <i class="fab fa-android text-4xl"></i>
                <div class="text-right">
                    <div class="text-sm">تحميل مباشر</div>
                    <div class="text-xl font-bold">APK للأندرويد</div>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <h3 class="text-2xl font-bold mb-4">تطبيق دولو</h3>
                <p class="text-gray-400 leading-relaxed">
                    أفضل منصة للحصول على العروض والخصومات الحصرية في مدينتك
                </p>
            </div>
            
            <div>
                <h4 class="text-lg font-bold mb-4">روابط سريعة</h4>
                <ul class="space-y-2">
                    <li><a href="#features" class="text-gray-400 hover:text-white transition">المميزات</a></li>
                    <li><a href="{{ route('landing.privacy') }}" class="text-gray-400 hover:text-white transition">سياسة الخصوصية</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">الشروط والأحكام</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">اتصل بنا</a></li>
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">لوحة التحكم</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-bold mb-4">تابعنا</h4>
                <div class="flex gap-4">
                    <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-purple-600 rounded-full flex items-center justify-center transition">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-purple-600 rounded-full flex items-center justify-center transition">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-purple-600 rounded-full flex items-center justify-center transition">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-gray-800 hover:bg-purple-600 rounded-full flex items-center justify-center transition">
                        <i class="fab fa-linkedin-in text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة - تطبيق دولو</p>
        </div>
    </div>
</footer>
@endsection
