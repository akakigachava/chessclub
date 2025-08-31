<template>
    <Head title="Admin Dashboard" />
    <AuthenticatedLayout>
      <template #header>
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 rounded-xl p-6 shadow-2xl">
          <h2 class="font-bold text-3xl text-white leading-tight flex items-center">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center mr-4 shadow-lg">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              </svg>
            </div>
            Admin Dashboard
          </h2>
          <p class="text-slate-300 mt-2">Manage members, tournaments, and club activities</p>
        </div>
      </template>
  
      <div class="py-8 bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
         
          <div v-if="$page.props.flash?.success" class="bg-gradient-to-r from-emerald-50 to-green-50 border-2 border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl mb-6 shadow-lg">
            <div class="flex items-center">
              <div class="w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <span class="font-medium">{{ $page.props.flash.success }}</span>
            </div>
          </div>
  
          <!-- Tab Navigation -->
          <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="flex border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50">
              <button @click="activeTab = 'members'" 
                      :class="{'border-b-4 border-blue-500 text-blue-600 bg-white': activeTab === 'members', 'text-slate-600 hover:text-blue-500': activeTab !== 'members'}" 
                      class="px-8 py-4 font-bold text-lg transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                Members
              </button>
              <button @click="activeTab = 'tournaments'" 
                      :class="{'border-b-4 border-blue-500 text-blue-600 bg-white': activeTab === 'tournaments', 'text-slate-600 hover:text-blue-500': activeTab !== 'tournaments'}" 
                      class="px-8 py-4 font-bold text-lg transition-all duration-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
                Tournaments
              </button>
            </div>
          </div>
  
          <!-- Members Tab -->
          <div v-show="activeTab === 'members'" class="space-y-8">
            <!-- Pending Registrations -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200 hover:shadow-2xl transition-all duration-300">
              <div class="p-8 bg-gradient-to-r from-orange-50 to-red-50 border-b border-slate-200">
                <div class="flex items-center mb-6">
                  <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-slate-800">Pending Registrations</h3>
                </div>
                
                <div v-if="pendingUsers && pendingUsers.length" class="overflow-x-auto">
                  <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-slate-100 to-slate-200">
                      <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider rounded-tl-lg">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider rounded-tr-lg">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white">
                      <tr v-for="user in pendingUsers" :key="user.id" class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">{{ user.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ user.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ user.phone || 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <button @click="approveUser(user.id)" 
                                  class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-bold py-2 px-4 rounded-lg mr-2 text-sm shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                            Approve
                          </button>
                          <button @click="rejectUser(user.id)" 
                                  class="bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                            Reject
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div v-else class="text-center py-12">
                  <div class="w-16 h-16 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                  </div>
                  <p class="text-xl font-medium text-slate-500">No pending registrations</p>
                </div>
              </div>
            </div>
  
            <!-- Approved Members -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200 hover:shadow-2xl transition-all duration-300">
              <div class="p-8 bg-gradient-to-r from-emerald-50 to-green-50 border-b border-slate-200">
                <div class="flex items-center mb-6">
                  <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-slate-800">Approved Members</h3>
                </div>
                
                <div v-if="approvedUsers && approvedUsers.length" class="overflow-x-auto">
                  <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-slate-100 to-slate-200">
                      <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider rounded-tl-lg">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider rounded-tr-lg">QR Code</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white">
                      <tr v-for="user in approvedUsers" :key="user.id" class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">{{ user.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ user.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ user.phone || 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <a :href="`/api/user/${user.id}/qrcode`" 
                             download 
                             class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download QR
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div v-else class="text-center py-12">
                  <div class="w-16 h-16 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                  </div>
                  <p class="text-xl font-medium text-slate-500">No approved members yet</p>
                </div>
              </div>
            </div>
          </div>
  
          <div v-show="activeTab === 'tournaments'" class="space-y-8">          
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200 hover:shadow-2xl transition-all duration-300">
              <div class="p-8 bg-gradient-to-r from-purple-50 to-blue-50 border-b border-slate-200">
                <div class="flex items-center mb-6">
                  <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-slate-800">Create New Tournament</h3>
                </div>
                
                <form @submit.prevent="createTournament" class="space-y-6">
                  <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2" for="name">
                      Tournament Name
                    </label>
                    <input v-model="tournamentForm.name" 
                           id="name" 
                           type="text" 
                           required
                           class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                  </div>
                  
                  <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2" for="start_date">
                      Start Date & Time
                    </label>
                    <input v-model="tournamentForm.start_date" 
                           id="start_date" 
                           type="datetime-local" 
                           required
                           class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                  </div>
                  
                  <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2" for="location">
                      Location
                    </label>
                    <input v-model="tournamentForm.location" 
                           id="location" 
                           type="text" 
                           required
                           class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                  </div>
                  
                  <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2" for="description">
                      Description
                    </label>
                    <textarea v-model="tournamentForm.description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm resize-none"></textarea>
                  </div>
                  
                  <button type="submit" 
                          :disabled="tournamentForm.processing"
                          class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                    <svg v-if="tournamentForm.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ tournamentForm.processing ? 'Creating...' : 'Create Tournament' }}
                  </button>
                </form>
              </div>
            </div>
  
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200 hover:shadow-2xl transition-all duration-300">
              <div class="p-8 bg-gradient-to-r from-violet-50 to-purple-50 border-b border-slate-200">
                <div class="flex items-center mb-6">
                  <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <h3 class="text-2xl font-bold text-slate-800">Upcoming Tournaments</h3>
                </div>
                
                <div v-if="tournaments && tournaments.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  <div v-for="tournament in tournaments" :key="tournament.id" 
                       class="bg-gradient-to-br from-white to-slate-50 border-2 border-slate-200 rounded-2xl p-6 shadow-lg hover:shadow-2xl hover:border-purple-300 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between mb-4">
                      <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                      </div>
                      <div class="w-3 h-3 bg-green-400 rounded-full shadow-lg"></div>
                    </div>
                    <h4 class="font-bold text-xl text-slate-800 mb-3">{{ tournament.name }}</h4>
                    <div class="space-y-2 mb-4">
                      <div class="flex items-center text-slate-600 bg-slate-50 p-2 rounded-lg">
                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-medium">{{ formatDate(tournament.start_date) }}</span>
                      </div>
                      <div class="flex items-center text-slate-600 bg-slate-50 p-2 rounded-lg">
                        <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="font-medium">{{ tournament.location }}</span>
                      </div>
                    </div>
                    <p class="text-slate-700 leading-relaxed">{{ tournament.description }}</p>
                  </div>
                </div>
                <div v-else class="text-center py-12">
                  <div class="w-16 h-16 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                  <p class="text-xl font-medium text-slate-500">No upcoming tournaments</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { Head, useForm, router } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { ref } from 'vue';
  
  const props = defineProps({
    pendingUsers: {
      type: Array,
      default: () => []
    },
    approvedUsers: {
      type: Array,
      default: () => []
    },
    tournaments: {
      type: Array,
      default: () => []
    },
  });
  
  const activeTab = ref('members');
  
  const approveUser = (userId) => {
    const form = useForm({});
    form.post(route('admin.users.approve', { user: userId }), {
      preserveScroll: true,
      onSuccess: () => {
      },
      onError: (errors) => {
        console.error('Error approving user:', errors);
      }
    });
  };
  
  const rejectUser = (userId) => {
    if (confirm('Are you sure you want to reject this user?')) {
      const form = useForm({});
      form.post(route('admin.users.reject', { user: userId }), {
        preserveScroll: true,
        onSuccess: () => {
        },
        onError: (errors) => {
          console.error('Error rejecting user:', errors);
        }
      });
    }
  };
  
  const tournamentForm = useForm({
    name: '',
    start_date: '',
    location: '',
    description: '',
  });
  
  const createTournament = () => {
    tournamentForm.post(route('admin.tournaments.create'), {
      preserveScroll: true,
      onSuccess: () => {
        tournamentForm.reset();
      },
      onError: (errors) => {
        console.error('Error creating tournament:', errors);
      }
    });
  };
  
  const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleString();
  };
  </script>