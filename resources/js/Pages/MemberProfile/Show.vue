<template>
    <Head title="Member Profile" />
    
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Your Member Profile
        </h2>
      </template>
  
      <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Your Member ID</h3>
            <div class="flex flex-col items-center">
              <img :src="qrCodeUrl" alt="Member QR Code" class="w-48 h-48 mb-4 border rounded-lg">
              <a :href="qrCodeUrl" download="chessclub-member-qr.png" 
                 class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none transition ease-in-out duration-150">
                Download QR Code
              </a>
            </div>
          </div>
  
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Account Information</h3>
            <div class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-gray-500">Full Name</label>
                <p class="mt-1 text-gray-900">{{ user.name }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-500">Email</label>
                <p class="mt-1 text-gray-900">{{ user.email }}</p>
              </div>
              <div v-if="user.phone">
                <label class="block text-sm font-medium text-gray-500">Phone</label>
                <p class="mt-1 text-gray-900">{{ user.phone }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-500">Member Since</label>
                <p class="mt-1 text-gray-900">{{ formatDate(user.created_at) }}</p>
              </div>
            </div>
          </div>
  
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Membership Status</h3>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-500">Fee Status</label>
                <div class="mt-1 flex items-center">
                  <span :class="{
                    'bg-green-100 text-green-800': user.fee_status,
                    'bg-yellow-100 text-yellow-800': !user.fee_status
                  }" class="px-3 py-1 rounded-full text-sm font-medium">
                    {{ user.fee_status ? 'Paid' : 'Payment Due' }}
                  </span>
                </div>
              </div>
              
              <div v-if="!user.fee_status && feeDeadline">
                <label class="block text-sm font-medium text-gray-500">Payment Deadline</label>
                <p class="mt-1 text-gray-900">{{ formatDate(feeDeadline) }}</p>
                <p class="mt-2 text-red-600 text-sm">
                  Please pay before this date to maintain your membership
                </p>
              </div>
              
              <div v-else-if="user.fee_status && feeDeadline">
                <label class="block text-sm font-medium text-gray-500">Paid Until</label>
                <p class="mt-1 text-gray-900">{{ formatDate(feeDeadline) }}</p>
              </div>
              
              <button @click="handlePayment" 
                      class="w-full mt-4 inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none transition ease-in-out duration-150">
                Pay Membership Fee
              </button>
            </div>
          </div>
          
          <div class="md:col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Upcoming Tournaments</h3>
            
            <div v-if="tournaments.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div v-for="tournament in tournaments" :key="tournament.id" class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                <h4 class="font-bold text-lg text-blue-700">{{ tournament.name }}</h4>
                <div class="mt-2">
                  <div class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ formatDate(tournament.start_date) }}</span>
                  </div>
                  <div v-if="tournament.location" class="flex items-center mt-1 text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ tournament.location }}</span>
                  </div>
                </div>
                <p v-if="tournament.description" class="mt-3 text-gray-700">{{ tournament.description }}</p>
                <button @click="handleTournamentRegistration(tournament)" 
                        class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none transition ease-in-out duration-150">
                  Register for Tournament
                </button>
              </div>
            </div>
            
            <div v-else class="text-center py-8">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              <p class="mt-4 text-lg text-gray-500">No upcoming tournaments scheduled</p>
              <p class="text-sm text-gray-400">Check back soon for new tournament announcements!</p>
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
  
  const handlePayment = () => {
    alert('Payment functionality will be implemented soon!');
  };
  
  const handleTournamentRegistration = (tournament) => {
    alert(`Registration for "${tournament.name}" will be implemented soon!`);
  };
  </script>