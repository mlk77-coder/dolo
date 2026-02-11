@extends('layouts.landing')

@section('title', 'سياسة الخصوصية - تطبيق دولو')

@section('content')
<!-- Header -->
<header class="gradient-bg text-white py-6">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center">
            <a href="{{ route('landing.index') }}" class="text-2xl font-bold">تطبيق دولو</a>
            <a href="{{ route('landing.index') }}" class="text-white hover:text-yellow-300 transition">
                <i class="fas fa-home ml-2"></i>
                الرئيسية
            </a>
        </div>
    </div>
</header>

<!-- Privacy Policy Content -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
            <h1 class="text-4xl font-bold mb-8 gradient-text">سياسة الخصوصية</h1>
            
            <div class="text-gray-600 leading-relaxed space-y-6">
                <p class="text-lg">
                    آخر تحديث: {{ date('Y/m/d') }}
                </p>
                
                <div class="border-r-4 border-purple-500 pr-4 bg-purple-50 p-4 rounded">
                    <p class="font-semibold text-gray-800">
                        نحن في تطبيق دولو نلتزم بحماية خصوصيتك وأمان بياناتك الشخصية. توضح هذه السياسة كيفية جمع واستخدام وحماية معلوماتك.
                    </p>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">1. المعلومات التي نجمعها</h2>
                <p>نقوم بجمع الأنواع التالية من المعلومات:</p>
                
                <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">1.1 المعلومات الشخصية</h3>
                <ul class="list-disc list-inside space-y-2 mr-6">
                    <li>الاسم الكامل</li>
                    <li>عنوان البريد الإلكتروني</li>
                    <li>رقم الهاتف</li>
                    <li>العنوان (للتوصيل)</li>
                    <li>تاريخ الميلاد (اختياري)</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">1.2 معلومات الاستخدام</h3>
                <ul class="list-disc list-inside space-y-2 mr-6">
                    <li>سجل التصفح داخل التطبيق</li>
                    <li>العروض التي تم عرضها أو شراؤها</li>
                    <li>تفضيلات المستخدم</li>
                    <li>معلومات الجهاز (نوع الجهاز، نظام التشغيل)</li>
                    <li>عنوان IP</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">1.3 معلومات الموقع</h3>
                <p>
                    نجمع معلومات الموقع الجغرافي (بإذنك) لعرض العروض القريبة منك وتحسين تجربتك في التطبيق.
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">2. كيفية استخدام المعلومات</h2>
                <p>نستخدم المعلومات التي نجمعها للأغراض التالية:</p>
                <ul class="list-disc list-inside space-y-2 mr-6">
                    <li>تقديم وتحسين خدماتنا</li>
                    <li>معالجة الطلبات والمعاملات</li>
                    <li>إرسال إشعارات حول العروض الجديدة</li>
                    <li>تخصيص تجربة المستخدم</li>
                    <li>التواصل معك بخصوص حسابك أو طلباتك</li>
                    <li>تحليل استخدام التطبيق لتحسين الخدمة</li>
                    <li>منع الاحتيال وضمان الأمان</li>
                    <li>الامتثال للمتطلبات القانونية</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">3. مشاركة المعلومات</h2>
                <p>نحن لا نبيع معلوماتك الشخصية لأطراف ثالثة. قد نشارك معلوماتك في الحالات التالية:</p>
                
                <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">3.1 مع التجار</h3>
                <p>
                    نشارك المعلومات الضرورية مع التجار لمعالجة طلباتك وتوصيل المنتجات (الاسم، العنوان، رقم الهاتف).
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">3.2 مزودي الخدمات</h3>
                <p>
                    نستخدم مزودي خدمات خارجيين موثوقين لمساعدتنا في تشغيل التطبيق (استضافة، معالجة الدفع، التحليلات).
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mt-6 mb-3">3.3 المتطلبات القانونية</h3>
                <p>
                    قد نكشف عن معلوماتك إذا كان ذلك مطلوباً بموجب القانون أو لحماية حقوقنا أو سلامة المستخدمين.
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">4. أمان المعلومات</h2>
                <p>
                    نتخذ تدابير أمنية صارمة لحماية معلوماتك الشخصية، بما في ذلك:
                </p>
                <ul class="list-disc list-inside space-y-2 mr-6">
                    <li>تشفير البيانات أثناء النقل والتخزين</li>
                    <li>استخدام خوادم آمنة ومحمية</li>
                    <li>تقييد الوصول إلى المعلومات الشخصية</li>
                    <li>مراقبة الأنظمة بانتظام للكشف عن الثغرات الأمنية</li>
                    <li>تدريب الموظفين على أفضل ممارسات الأمان</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">5. حقوقك</h2>
                <p>لديك الحقوق التالية فيما يتعلق بمعلوماتك الشخصية:</p>
                <ul class="list-disc list-inside space-y-2 mr-6">
                    <li><strong>الوصول:</strong> يمكنك طلب نسخة من معلوماتك الشخصية</li>
                    <li><strong>التصحيح:</strong> يمكنك تحديث أو تصحيح معلوماتك</li>
                    <li><strong>الحذف:</strong> يمكنك طلب حذف حسابك ومعلوماتك</li>
                    <li><strong>الاعتراض:</strong> يمكنك الاعتراض على معالجة معلوماتك</li>
                    <li><strong>نقل البيانات:</strong> يمكنك طلب نقل بياناتك إلى خدمة أخرى</li>
                    <li><strong>سحب الموافقة:</strong> يمكنك سحب موافقتك على معالجة بياناتك في أي وقت</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">6. ملفات تعريف الارتباط (Cookies)</h2>
                <p>
                    نستخدم ملفات تعريف الارتباط وتقنيات مشابهة لتحسين تجربتك وتحليل استخدام التطبيق. يمكنك التحكم في ملفات تعريف الارتباط من خلال إعدادات المتصفح أو الجهاز.
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">7. خصوصية الأطفال</h2>
                <p>
                    تطبيقنا غير موجه للأطفال دون سن 13 عاماً. نحن لا نجمع معلومات شخصية من الأطفال عن قصد. إذا علمنا أننا جمعنا معلومات من طفل دون سن 13 عاماً، سنحذفها فوراً.
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">8. الروابط الخارجية</h2>
                <p>
                    قد يحتوي تطبيقنا على روابط لمواقع أو خدمات خارجية. نحن لسنا مسؤولين عن ممارسات الخصوصية لهذه المواقع. ننصحك بمراجعة سياسات الخصوصية الخاصة بهم.
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">9. التحديثات على السياسة</h2>
                <p>
                    قد نقوم بتحديث سياسة الخصوصية من وقت لآخر. سنخطرك بأي تغييرات جوهرية عبر التطبيق أو البريد الإلكتروني. استمرار استخدامك للتطبيق بعد التحديثات يعني موافقتك على السياسة المحدثة.
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">10. الاحتفاظ بالبيانات</h2>
                <p>
                    نحتفظ بمعلوماتك الشخصية طالما كان حسابك نشطاً أو حسب الحاجة لتقديم خدماتنا. يمكنك طلب حذف حسابك في أي وقت، وسنحذف معلوماتك خلال 30 يوماً (ما لم يكن الاحتفاظ بها مطلوباً قانونياً).
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">11. نقل البيانات الدولي</h2>
                <p>
                    قد يتم نقل معلوماتك ومعالجتها في دول أخرى. نتخذ خطوات لضمان حماية بياناتك وفقاً لهذه السياسة بغض النظر عن موقع المعالجة.
                </p>

                <h2 class="text-2xl font-bold text-gray-800 mt-8 mb-4">12. اتصل بنا</h2>
                <p>
                    إذا كان لديك أي أسئلة أو استفسارات حول سياسة الخصوصية أو ممارساتنا، يرجى التواصل معنا:
                </p>
                
                <div class="bg-gray-100 p-6 rounded-lg mt-4">
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-purple-600"></i>
                            <span>البريد الإلكتروني: <a href="mailto:privacy@dealsapp.com" class="text-purple-600 hover:underline">privacy@dealsapp.com</a></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-purple-600"></i>
                            <span>الهاتف: +966 XX XXX XXXX</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt text-purple-600"></i>
                            <span>العنوان: المملكة العربية السعودية</span>
                        </li>
                    </ul>
                </div>

                <div class="border-t-2 border-gray-200 pt-6 mt-8">
                    <p class="text-sm text-gray-500">
                        بموجب استخدامك لتطبيق دولو، فإنك توافق على شروط سياسة الخصوصية هذه. إذا كنت لا توافق على هذه السياسة، يرجى عدم استخدام التطبيق.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8">
    <div class="container mx-auto px-4 text-center">
        <p class="text-gray-400">&copy; {{ date('Y') }} جميع الحقوق محفوظة - تطبيق دولو</p>
        <div class="mt-4">
            <a href="{{ route('landing.index') }}" class="text-gray-400 hover:text-white transition mx-3">الرئيسية</a>
            <a href="{{ route('landing.privacy') }}" class="text-gray-400 hover:text-white transition mx-3">سياسة الخصوصية</a>
        </div>
    </div>
</footer>
@endsection
