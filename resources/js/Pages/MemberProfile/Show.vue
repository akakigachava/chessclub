<template>
    <Head title="Member Profile" />
    
    <AuthenticatedLayout>
      <template #header>
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-xl p-6 shadow-2xl">
          <h2 class="font-bold text-3xl text-white leading-tight flex items-center">
            <div class="w-10 h-10 bg-amber-400 rounded-lg flex items-center justify-center mr-4 shadow-lg">
              <svg class="w-6 h-6 text-slate-900" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 22H5a1 1 0 01-1-1v-8a1 1 0 011-1h1V9a1 1 0 011-1h1V6a1 1 0 011-1h1V3a1 1 0 011-1h2a1 1 0 011 1v2h1a1 1 0 011 1v2h1a1 1 0 011 1v3h1a1 1 0 011 1v8a1 1 0 01-1 1zM6 20h12v-6h-1a1 1 0 01-1-1v-3h-1a1 1 0 01-1-1V8h-1a1 1 0 01-1-1V5h-1a1 1 0 01-1-1V4h-2v1a1 1 0 01-1 1H8a1 1 0 01-1 1v2a1 1 0 01-1 1H5v3a1 1 0 01-1 1H6v6z"/>
              </svg>
            </div>
            Your Member Profile
          </h2>
          <p class="text-slate-300 mt-2">Manage your chess club membership and tournament registration</p>
        </div>
      </template>
  
      <div class="py-8 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-slate-200 hover:shadow-2xl transition-all duration-300">
            <div class="text-center">
              <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-slate-800 mb-6">Your Member ID</h3>
            </div>
            <div class="flex flex-col items-center">
              <div class="relative group">
                <img :src="qrCodeUrl" alt="Member QR Code" class="w-52 h-52 mb-6 border-4 border-slate-100 rounded-2xl shadow-xl transition-transform duration-300 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              </div>
              <a :href="qrCodeUrl" download="chessclub-member-qr.png" 
                 class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download QR Code
              </a>
            </div>
          </div>
  
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-slate-200 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center mb-6">
              <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-slate-800">Account Information</h3>
            </div>
            <div class="space-y-6">
              <div class="bg-gradient-to-r from-slate-50 to-blue-50 p-4 rounded-xl border border-slate-100">
                <label class="block text-sm font-semibold text-slate-600 mb-1">Full Name</label>
                <p class="text-lg font-medium text-slate-900">{{ user.name }}</p>
              </div>
              <div class="bg-gradient-to-r from-slate-50 to-blue-50 p-4 rounded-xl border border-slate-100">
                <label class="block text-sm font-semibold text-slate-600 mb-1">Email</label>
                <p class="text-lg font-medium text-slate-900">{{ user.email }}</p>
              </div>
              <div v-if="user.phone" class="bg-gradient-to-r from-slate-50 to-blue-50 p-4 rounded-xl border border-slate-100">
                <label class="block text-sm font-semibold text-slate-600 mb-1">Phone</label>
                <p class="text-lg font-medium text-slate-900">{{ user.phone }}</p>
              </div>
              <div class="bg-gradient-to-r from-slate-50 to-blue-50 p-4 rounded-xl border border-slate-100">
                <label class="block text-sm font-semibold text-slate-600 mb-1">Member Since</label>
                <p class="text-lg font-medium text-slate-900">{{ formatDate(user.created_at) }}</p>
              </div>
            </div>
          </div>
  
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-slate-200 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center mb-6">
              <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-slate-800">Membership Status</h3>
            </div>
            <div class="space-y-6">
              <div class="bg-gradient-to-r from-slate-50 to-blue-50 p-4 rounded-xl border border-slate-100">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Fee Status</label>
                <div class="flex items-center">
                  <span :class="{
                    'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border-emerald-200': user.fee_status,
                    'bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border-amber-200': !user.fee_status
                  }" class="px-4 py-2 rounded-full text-sm font-bold border-2 shadow-sm">
                    {{ user.fee_status ? 'Paid' : 'Payment Due' }}
                  </span>
                </div>
              </div>
              
              <div v-if="!user.fee_status && feeDeadline" class="bg-gradient-to-r from-red-50 to-pink-50 p-4 rounded-xl border border-red-200">
                <label class="block text-sm font-semibold text-red-700 mb-1">Payment Deadline</label>
                <p class="text-lg font-medium text-red-900 mb-2">{{ formatDate(feeDeadline) }}</p>
                <p class="text-red-600 text-sm font-medium">
                  Please pay before this date to maintain your membership
                </p>
              </div>
              
              <div v-else-if="user.fee_status && feeDeadline" class="bg-gradient-to-r from-emerald-50 to-green-50 p-4 rounded-xl border border-emerald-200">
                <label class="block text-sm font-semibold text-emerald-700 mb-1">Paid Until</label>
                <p class="text-lg font-medium text-emerald-900">{{ formatDate(feeDeadline) }}</p>
              </div>
              

            </div>
          </div>
          
          <div class="md:col-span-3 bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-slate-200 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center mb-8">
              <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-3xl font-bold text-slate-800">Upcoming Tournaments</h3>
                <p class="text-slate-600 mt-1">Register for exciting chess competitions</p>
              </div>
            </div>
            
            <div v-if="tournaments.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div v-for="tournament in tournaments" :key="tournament.id" 
                   class="bg-gradient-to-br from-white to-slate-50 border-2 border-slate-200 rounded-2xl p-6 hover:shadow-2xl hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="flex items-start justify-between mb-4">
                  <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                  </div>
                  <div class="w-3 h-3 bg-green-400 rounded-full shadow-lg group-hover:bg-green-500 transition-colors duration-300"></div>
                </div>
                
                <h4 class="font-bold text-xl text-slate-800 mb-4 group-hover:text-blue-700 transition-colors duration-300">{{ tournament.name }}</h4>
                
                <div class="space-y-3 mb-6">
                  <div class="flex items-center text-slate-600 bg-slate-50 p-3 rounded-lg">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                      <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                    <span class="font-medium">{{ formatDate(tournament.start_date) }}</span>
                  </div>
                  <div v-if="tournament.location" class="flex items-center text-slate-600 bg-slate-50 p-3 rounded-lg">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                      <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                      </svg>
                    </div>
                    <span class="font-medium">{{ tournament.location }}</span>
                  </div>
                </div>
                
                <p v-if="tournament.description" class="text-slate-700 mb-6 leading-relaxed">{{ tournament.description }}</p>
                

              </div>
            </div>
            
            <div v-else class="text-center py-16">
              <div class="w-24 h-24 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
              <h4 class="text-2xl font-bold text-slate-600 mb-2">No upcoming tournaments scheduled</h4>
              <p class="text-lg text-slate-500 mb-6">Check back soon for new tournament announcements!</p>
              <div class="w-32 h-1 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full mx-auto"></div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { Head } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  
  const props = defineProps({
    user: {
      type: Object,
      required: true
    },
    tournaments: {
      type: Array,
      default: () => []
    },
    feeDeadline: {
      type: String,
      default: null
    },
    qrCodeUrl: {
      type: String,
      required: true
    }
  });
  
  const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    });
  };
  </script>