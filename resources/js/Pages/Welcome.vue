<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const showAuthModal = ref(false);
const authMode = ref('login'); 
const isVisible = ref(false);

const loginForm = useForm({
    email: '',
    password: '',
    remember: false,
});

const submitLogin = () => {
    loginForm.post(route('login'), {
        onFinish: () => loginForm.reset('password'),
    });
};

const openAuthModal = (mode) => {
    if (mode === 'register') {
        window.location.href = route('register');
        return;
    }
    authMode.value = mode;
    showAuthModal.value = true;
};

const closeAuthModal = () => {
    showAuthModal.value = false;
    loginForm.reset();
};

const goToRegistration = () => {
    closeAuthModal();
    window.location.href = route('register');
};

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});
</script>

<template>
    <Head title="ChessClub64 - ბიზნეს რეგისტრაციის პლატფორმა" />
    
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white overflow-hidden relative">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-2000"></div>
            <div class="absolute top-40 left-40 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-4000"></div>
        </div>

        <div class="relative z-10">
            <header class="flex justify-between items-center px-6 py-8 backdrop-blur-sm bg-white/5 border-b border-white/10">
                <div class="flex items-center space-x-4 transform transition-all duration-500"
                     :class="isVisible ? 'translate-x-0 opacity-100' : '-translate-x-10 opacity-0'">
                    <div class="w-16 h-16 bg-white/10 rounded-xl flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 backdrop-blur-sm border border-white/20">
                        <img src="/images/logo1.png" alt="ChessClub64 ლოგო" class="w-12 h-12 object-contain">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                            ჭადრაკის კლუბი 64 საქართველო
                        </h1>
                        <p class="text-sm text-gray-300">დახურული კლუბი ბიზნესმენებისა და საქმიანი ადამიანებითვის</p>
                    </div>
                </div>

                <nav v-if="canLogin" class="flex space-x-4 transform transition-all duration-500 delay-200"
                     :class="isVisible ? 'translate-x-0 opacity-100' : 'translate-x-10 opacity-0'">
                    <Link v-if="$page.props.auth.user"
                          :href="route('dashboard')"
                          class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                        მთავარი პანელი
                    </Link>
                    <template v-else>
                        <button @click="openAuthModal('login')"
                                class="px-6 py-2 border border-white/20 hover:bg-white/10 rounded-lg transition-all duration-300 hover:shadow-lg hover:border-white/40 hover:scale-105">
                            შესვლა
                        </button>
                        <Link v-if="canRegister"
                              :href="route('register')"
                              class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                            რეგისტრაცია
                        </Link>
                    </template>
                </nav>
            </header>

            <main class="flex flex-col items-center justify-center min-h-[70vh] px-6 text-center">
                <div class="max-w-4xl mx-auto">
                    <div class="mb-12 transform transition-all duration-700 delay-300"
                         :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <div class="mb-8 flex justify-center">
                            <div class="w-32 h-32 bg-white/10 rounded-2xl flex items-center justify-center shadow-2xl backdrop-blur-sm border border-white/20 hover:scale-105 transition-all duration-300">
                                <img src="/images/logo1.png" alt="ChessClub64 ლოგო" class="w-24 h-24 object-contain">
                            </div>
                        </div>
                        
                        <h2 class="text-4xl md:text-3xl font-bold mb-6 bg-gradient-to-r from-white via-purple-200 to-blue-200 bg-clip-text text-transparent leading-tight">
                            <p>კეთილი იყოს თქვენი მობრძანება</p>
                            <p> ჭადრაკის კლუბ 64-ში!</p>
                        </h2>
                        <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                            კლუბი შეიქმნა ბიზნესმენებისა და საქმიანი ადამიანებისთვის. ჭადრაკის სიყვარული და მისი მნიშვნელობა ყოველდღიურ ცხოვრებაში არის მთავარი, რაც გვაერთიანებს. კლუბში თქვენ იპოვით ადგილს განტვირთვისთვისა და მეგობრებთან ერთად დროის საინტერესოდ გატარებისთვის.
                        </p>
                        <div>
                            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                                ჭადრაკი - ლიდერების არჩევანი!
                            </p>
                        </div>

                        <div class="text-left max-w-3xl mx-auto space-y-6 mb-8">
                            <h3 class="text-2xl font-bold text-center mb-6 bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                                აირჩიეთ კლუბის წევრობის სტატუსი
                            </h3>
                            
                            <!-- საბაზისო -->
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-6 border border-white/10 hover:border-purple-500/50 transition-all duration-300">
                                <h4 class="text-xl font-bold text-purple-400 mb-2">საბაზისო - 150₾ თვეში / 1500₾ წელიწადში ᲔᲠᲗᲯᲔᲠᲐᲓᲘ ᲒᲐᲓᲐᲮᲓᲘᲗ</h4>
                                <ul class="text-gray-300 space-y-2 text-sm">
                                    <li>• წვდომა ჭადრაკის მაგიდებზე და კომპლექტზე</li>
                                    <li>• 1 შესავალი გაკვეთილი თვეში</li>
                                    <li>• კვირის ღონისძიებაზე უფასო დასწრება</li>
                                    <li>• ფაზლების ამოხსნაში მონაწილეობა</li>
                                    <li>• პერსონალური QR კოდი</li>
                                    <li>• პროგრესის ბარათი და ბეჯები</li>
                                    <li>• ლოიალურობის პროგრამაში ჩართვა</li>
                                    <li>• 10% ფასდაკლება რესტორანში</li>
                                </ul>
                            </div>

                            <!-- პრემიუმი -->
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-6 border border-white/10 hover:border-blue-500/50 transition-all duration-300">
                                <h4 class="text-xl font-bold text-blue-400 mb-2">პრემიუმი - 250₾ თვეში / 2500₾ წელიწადში</h4>
                                <ul class="text-gray-300 space-y-2 text-sm">
                                    <li>• საბაზისო-ს ყველა უპირატესობა</li>
                                    <li>• უფასო მონაწილეობა ტურნირებზე</li>
                                    <li>• ჯგუფური გაკვეთილები თვეში ორჯერ</li>
                                    <li>• მეგობრის მოყვანის უფლება თვეში ერთხელ</li>
                                    <li>• პრიორიტეტული მაგიდის ჯავშანი</li>
                                    <li>• ჭადრაკი & ღვინო / ჭადრაკი & ჩაი საღამოებზე წვდომა</li>
                                    <li>• ლოიალურობის ქულების სისტემა</li>
                                    <li>• მცირე პარტნიორული ფასდაკლებები</li>
                                    <li>• სპეციალური ბეიჯი</li>
                                    <li>• 15% ფასდაკლება რესტორანში</li>
                                </ul>
                            </div>

                            <!-- ექსკლუზივი -->
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-6 border border-white/10 hover:border-yellow-500/50 transition-all duration-300">
                                <h4 class="text-xl font-bold text-yellow-400 mb-2">ექსკლუზივი - 400₾ თვეში / 4000₾ წელიწადში</h4>
                                <ul class="text-gray-300 space-y-2 text-sm">
                                    <li>• პრემიუმი-ს ყველა უპირატესობა</li>
                                    <li>• ინდივიდუალური გაკვეთილი თვეში ერთხელ</li>
                                    <li>• VIP ზონა და მაგიდების პრიორიტეტული წვდომა</li>
                                    <li>• დახურული საღამოები და სპეციალური ღონისძიებები</li>
                                    <li>• ექსკლუზივი წევრების საღამოები</li>
                                    <li>• მასტერკლასი/სეანსი მოწვეული დიდოსტატთან</li>
                                    <li>• „წევრი +1" სპეციალურ საღამოზე</li>
                                    <li>• ჭადრაკის ღვინო საჩუქრად</li>
                                    <li>• პერსონალიზირებული ბარათი ან მეტალის ბეჯი</li>
                                    <li>• პრიორიტეტული მაგიდისა და სივრცის დაჯავშნა</li>
                                    <li>• გაფართოებული პარტნიორული ფასდაკლებები</li>
                                    <li>• სასმელი კლუბში მოსვლისას</li>
                                    <li>• ექსკლუზიური ლოიალურობის სტატუსი</li>
                                    <li>• 20% ფასდაკლება რესტორანში</li>
                                </ul>
                            </div>

                            <!-- დღის სტუმარი -->
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-6 border border-white/10 hover:border-green-500/50 transition-all duration-300">
                                <h4 class="text-xl font-bold text-green-400 mb-2">დღის სტუმარი - 60₾</h4>
                                <p class="text-gray-300 text-sm">ერთჯერადი დასწრება კლუბის ღონისძიებაზე</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="canLogin && !$page.props.auth.user" class="transform transition-all duration-700 delay-800"
                         :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <div class="mb-6">
                            <Link :href="route('register')"
                                  class="px-10 py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-xl text-lg font-semibold transition-all duration-300 shadow-2xl hover:shadow-purple-500/25 transform hover:-translate-y-1 hover:scale-105 relative overflow-hidden group inline-block">
                                <span class="relative z-10">დაიწყეთ დღესვე</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </Link>
                        </div>
                        <p class="text-sm text-gray-400">
                            შემოუერთდით ჩვენს ბიზნეს საზოგადოებას • სწრაფი რეგისტრაცია • პროფესიონალური მხარდაჭერა
                        </p>
                    </div>
                </div>
            </main>

            <footer class="text-center py-8 text-gray-400 text-sm backdrop-blur-sm bg-white/5 border-t border-white/10">
                <div class="max-w-4xl mx-auto">
                    <p class="mb-2">© 2024 ChessClub64 - პროფესიონალური ბიზნეს რეგისტრაციის პლატფორმა</p>
                    <div class="flex justify-center space-x-6 text-xs">
                        <a href="#" class="hover:text-purple-400 transition-colors">კონფიდენციალურობის პოლიტიკა</a>
                        <a href="#" class="hover:text-purple-400 transition-colors">მომსახურების წესები</a>
                        <a href="#" class="hover:text-purple-400 transition-colors">დაგვიკავშირდით</a>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Login Modal Only -->
        <div v-if="showAuthModal && authMode === 'login'" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-slate-800/90 backdrop-blur-md rounded-2xl p-8 w-full max-w-md mx-4 border border-white/20 shadow-2xl animate-slide-up">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <img src="/images/logo1.png" alt="ლოგო" class="w-8 h-8 object-contain">
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                            მოგესალმებით
                        </h2>
                    </div>
                    <button @click="closeAuthModal" class="text-gray-400 hover:text-white transition-colors hover:scale-110 transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitLogin" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">ელექტრონული ფოსტა</label>
                        <input v-model="loginForm.email" type="email" required
                               class="w-full px-4 py-3 bg-slate-700/50 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-200 hover:bg-slate-700/70"
                               placeholder="შეიყვანეთ ელფოსტა">
                        <div v-if="loginForm.errors.email" class="text-red-400 text-sm mt-1">{{ loginForm.errors.email }}</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">პაროლი</label>
                        <input v-model="loginForm.password" type="password" required
                               class="w-full px-4 py-3 bg-slate-700/50 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-200 hover:bg-slate-700/70"
                               placeholder="შეიყვანეთ პაროლი">
                        <div v-if="loginForm.errors.password" class="text-red-400 text-sm mt-1">{{ loginForm.errors.password }}</div>
                    </div>

                    <div class="flex items-center">
                        <input v-model="loginForm.remember" type="checkbox" id="remember"
                               class="rounded border-gray-600 text-purple-600 focus:ring-purple-500">
                        <label for="remember" class="ml-2 text-sm text-gray-300">დამახსოვრება</label>
                    </div>

                    <button type="submit" :disabled="loginForm.processing"
                            class="w-full py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-lg font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed hover:scale-105 transform">
                        {{ loginForm.processing ? 'შესვლა...' : 'შესვლა' }}
                    </button>

                    <div class="text-center">
                        <Link :href="route('register')"
                              class="text-purple-400 hover:text-purple-300 text-sm transition-colors hover:underline">
                            არ გაქვთ ანგარიში? დარეგისტრირდით აქ
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes fade-in {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

.animate-slide-up {
    animation: slide-up 0.3s ease-out;
}
</style>