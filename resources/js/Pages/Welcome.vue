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

const registerForm = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submitLogin = () => {
    loginForm.post(route('login'), {
        onFinish: () => loginForm.reset('password'),
    });
};

const submitRegister = () => {
    registerForm.post(route('register'), {
        onFinish: () => registerForm.reset('password', 'password_confirmation'),
    });
};

const openAuthModal = (mode) => {
    authMode.value = mode;
    showAuthModal.value = true;
};

const closeAuthModal = () => {
    showAuthModal.value = false;
    loginForm.reset();
    registerForm.reset();
};

onMounted(() => {
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});
</script>

<template>
    <Head title="ChessClub64 - Business Registration Platform" />
    
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
                        <img src="/images/logo.png" alt="ChessClub64 Logo" class="w-12 h-12 object-contain">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                            Club64 Georgia
                        </h1>
                        <p class="text-sm text-gray-300">Chess club registration platform for businessmans </p>
                    </div>
                </div>

                <nav v-if="canLogin" class="flex space-x-4 transform transition-all duration-500 delay-200"
                     :class="isVisible ? 'translate-x-0 opacity-100' : 'translate-x-10 opacity-0'">
                    <Link v-if="$page.props.auth.user"
                          :href="route('dashboard')"
                          class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                        Dashboard
                    </Link>
                    <template v-else>
                        <button @click="openAuthModal('login')"
                                class="px-6 py-2 border border-white/20 hover:bg-white/10 rounded-lg transition-all duration-300 hover:shadow-lg hover:border-white/40 hover:scale-105">
                            Sign In
                        </button>
                        <button v-if="canRegister"
                                @click="openAuthModal('register')"
                                class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                            Register
                        </button>
                    </template>
                </nav>
            </header>

            <main class="flex flex-col items-center justify-center min-h-[70vh] px-6 text-center">
                <div class="max-w-4xl mx-auto">
                    <div class="mb-12 transform transition-all duration-700 delay-300"
                         :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <div class="mb-8 flex justify-center">
                            <div class="w-32 h-32 bg-white/10 rounded-2xl flex items-center justify-center shadow-2xl backdrop-blur-sm border border-white/20 hover:scale-105 transition-all duration-300">
                                <img src="/images/logo.png" alt="ChessClub64 Logo" class="w-24 h-24 object-contain">
                            </div>
                        </div>
                        
                        <h2 class="text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-white via-purple-200 to-blue-200 bg-clip-text text-transparent leading-tight">
                            Welcome to Club64
                        </h2>
                        <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                            Chess club registration platform for businessmans. Join our professional community and manage your registration efficiently and easily.
                        </p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8 mb-12">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-500 hover:transform hover:-translate-y-3 hover:shadow-2xl hover:shadow-purple-500/20 group transform"
                             :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'"
                             :style="{ transitionDelay: '500ms' }">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 group-hover:text-blue-300 transition-colors">Easy Registration</h3>
                            <p class="text-gray-300 group-hover:text-gray-200 transition-colors">Simple and streamlined registration process with all necessary documentation.</p>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-500 hover:transform hover:-translate-y-3 hover:shadow-2xl hover:shadow-purple-500/20 group transform"
                             :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'"
                             :style="{ transitionDelay: '600ms' }">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 group-hover:text-pink-300 transition-colors">Secure Platform</h3>
                            <p class="text-gray-300 group-hover:text-gray-200 transition-colors">Your private information mails and phone number is protected with enterprise-grade security measures.</p>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-500 hover:transform hover:-translate-y-3 hover:shadow-2xl hover:shadow-purple-500/20 group transform"
                             :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'"
                             :style="{ transitionDelay: '700ms' }">
                            <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center mb-6 mx-auto group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.5a9.5 9.5 0 100 19 9.5 9.5 0 000-19z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-3 group-hover:text-orange-300 transition-colors">Professional Support</h3>
                            <p class="text-gray-300 group-hover:text-gray-200 transition-colors">Get dedicated support from chess masters and enjoy every moment in our chess club.</p>
                        </div>
                    </div>

                    <div v-if="canLogin && !$page.props.auth.user" class="transform transition-all duration-700 delay-800"
                         :class="isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'">
                        <div class="mb-6">
                            <button @click="openAuthModal('register')"
                                    class="px-10 py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-xl text-lg font-semibold transition-all duration-300 shadow-2xl hover:shadow-purple-500/25 transform hover:-translate-y-1 hover:scale-105 relative overflow-hidden group">
                                <span class="relative z-10">Get Started Today</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </button>
                        </div>
                        <p class="text-sm text-gray-400">
                            Join our business community • Quick setup • Professional support
                        </p>
                    </div>
                </div>
            </main>

            <footer class="text-center py-8 text-gray-400 text-sm backdrop-blur-sm bg-white/5 border-t border-white/10">
                <div class="max-w-4xl mx-auto">
                    <p class="mb-2">© 2024 ChessClub64 - Professional Business Registration Platform</p>
                    <div class="flex justify-center space-x-6 text-xs">
                        <a href="#" class="hover:text-purple-400 transition-colors">Privacy Policy</a>
                        <a href="#" class="hover:text-purple-400 transition-colors">Terms of Service</a>
                        <a href="#" class="hover:text-purple-400 transition-colors">Contact Us</a>
                    </div>
                </div>
            </footer>
        </div>

        <div v-if="showAuthModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 animate-fade-in">
            <div class="bg-slate-800/90 backdrop-blur-md rounded-2xl p-8 w-full max-w-md mx-4 border border-white/20 shadow-2xl animate-slide-up">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                            <img src="/images/logo.png" alt="Logo" class="w-8 h-8 object-contain">
                        </div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                            {{ authMode === 'login' ? 'Welcome Back' : 'Join ChessClub64' }}
                        </h2>
                    </div>
                    <button @click="closeAuthModal" class="text-gray-400 hover:text-white transition-colors hover:scale-110 transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form v-if="authMode === 'login'" @submit.prevent="submitLogin" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input v-model="loginForm.email" type="email" required
                               class="w-full px-4 py-3 bg-slate-700/50 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-200 hover:bg-slate-700/70"
                               placeholder="Enter your email">
                        <div v-if="loginForm.errors.email" class="text-red-400 text-sm mt-1">{{ loginForm.errors.email }}</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                        <input v-model="loginForm.password" type="password" required
                               class="w-full px-4 py-3 bg-slate-700/50 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-200 hover:bg-slate-700/70"
                               placeholder="Enter your password">
                        <div v-if="loginForm.errors.password" class="text-red-400 text-sm mt-1">{{ loginForm.errors.password }}</div>
                    </div>

                    <div class="flex items-center">
                        <input v-model="loginForm.remember" type="checkbox" id="remember"
                               class="rounded border-gray-600 text-purple-600 focus:ring-purple-500">
                        <label for="remember" class="ml-2 text-sm text-gray-300">Remember me</label>
                    </div>

                    <button type="submit" :disabled="loginForm.processing"
                            class="w-full py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-lg font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed hover:scale-105 transform">
                        {{ loginForm.processing ? 'Signing in...' : 'Sign In' }}
                    </button>

                    <div class="text-center">
                        <button type="button" @click="authMode = 'register'"
                                class="text-purple-400 hover:text-purple-300 text-sm transition-colors hover:underline">
                            Don't have an account? Register here
                        </button>
                    </div>
                </form>

                <form v-if="authMode === 'register'" @submit.prevent="submitRegister" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <input v-model="registerForm.name" type="text" required
                               class="w-full px-4 py-3 bg-slate-700/50 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-200 hover:bg-slate-700/70"
                               placeholder="Enter your full name">
                        <div v-if="registerForm.errors.name" class="text-red-400 text-sm mt-1">{{ registerForm.errors.name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input v-model="registerForm.email" type="email" required
                               class="w-full px-4 py-3 bg-slate-700/50 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-200 hover:bg-slate-700/70"
                               placeholder="Enter your email address">
                        <div v-if="registerForm.errors.email" class="text-red-400 text-sm mt-1">{{ registerForm.errors.email }}</div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                        <input v-model="registerForm.password" type="password" required
                               class="w-full px-4 py-3 bg-slate-700/50 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-200 hover:bg-slate-700/70"
                               placeholder="Create a strong password">
                        <div v-if="registerForm.errors.password" class="text-red-400 text-sm mt-1">{{ registerForm.errors.password }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                        <input v-model="registerForm.password_confirmation" type="password" required
                               class="w-full px-4 py-3 bg-slate-700/50 border border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-200 hover:bg-slate-700/70"
                               placeholder="Confirm your password">
                        <div v-if="registerForm.errors.password_confirmation" class="text-red-400 text-sm mt-1">{{ registerForm.errors.password_confirmation }}</div>
                    </div>

                    <button type="submit" :disabled="registerForm.processing"
                            class="w-full py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 rounded-lg font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed hover:scale-105 transform">
                        {{ registerForm.processing ? 'Creating account...' : 'Create Account' }}
                    </button>

                    <div class="text-center">
                        <button type="button" @click="authMode = 'login'"
                                class="text-purple-400 hover:text-purple-300 text-sm transition-colors hover:underline">
                            Already have an account? Sign in
                        </button>
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