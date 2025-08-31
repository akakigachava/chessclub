<template>
    <Head title="Admin Dashboard" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
      </template>
  
      <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
         
          <div v-if="$page.props.flash?.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ $page.props.flash.success }}
          </div>
  
          
          <div class="flex border-b border-gray-200">
            <button @click="activeTab = 'members'" 
                    :class="{'border-b-2 border-blue-500 text-blue-500': activeTab === 'members'}" 
                    class="px-4 py-2 font-medium hover:text-blue-500">
              Members
            </button>
            <button @click="activeTab = 'tournaments'" 
                    :class="{'border-b-2 border-blue-500 text-blue-500': activeTab === 'tournaments'}" 
                    class="px-4 py-2 font-medium hover:text-blue-500">
              Tournaments
            </button>
          </div>
  
          
          <div v-show="activeTab === 'members'">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
              <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium mb-4">Pending Registrations</h3>
                
                <div v-if="pendingUsers && pendingUsers.length" class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="user in pendingUsers" :key="user.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.phone || 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <button @click="approveUser(user.id)" 
                                  class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded mr-2 text-sm">
                            Approve
                          </button>
                          <button @click="rejectUser(user.id)" 
                                  class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">
                            Reject
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <p v-else class="text-gray-500">No pending registrations</p>
              </div>
            </div>
  
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium mb-4">Approved Members</h3>
                
                <div v-if="approvedUsers && approvedUsers.length" class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="user in approvedUsers" :key="user.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.phone || 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <a :href="`/api/user/${user.id}/qrcode`" 
                             download 
                             class="text-blue-500 hover:text-blue-700 text-sm">
                            Download QR
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <p v-else class="text-gray-500">No approved members yet</p>
              </div>
            </div>
          </div>
  
         
          <div v-show="activeTab === 'tournaments'">
    
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
              <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium mb-4">Create New Tournament</h3>
                
                <form @submit.prevent="createTournament">
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                      Tournament Name
                    </label>
                    <input v-model="tournamentForm.name" 
                           id="name" 
                           type="text" 
                           required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  </div>
                  
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="start_date">
                      Start Date & Time
                    </label>
                    <input v-model="tournamentForm.start_date" 
                           id="start_date" 
                           type="datetime-local" 
                           required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  </div>
                  
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="location">
                      Location
                    </label>
                    <input v-model="tournamentForm.location" 
                           id="location" 
                           type="text" 
                           required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                  </div>
                  
                  <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                      Description
                    </label>
                    <textarea v-model="tournamentForm.description" 
                              id="description" 
                              rows="4"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                  </div>
                  
                  <button type="submit" 
                          :disabled="tournamentForm.processing"
                          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50">
                    {{ tournamentForm.processing ? 'Creating...' : 'Create Tournament' }}
                  </button>
                </form>
              </div>
            </div>
  
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium mb-4">Upcoming Tournaments</h3>
                
                <div v-if="tournaments && tournaments.length" class="space-y-4">
                  <div v-for="tournament in tournaments" :key="tournament.id" class="border rounded-lg p-4">
                    <h4 class="font-bold text-lg">{{ tournament.name }}</h4>
                    <p class="text-gray-600">{{ formatDate(tournament.start_date) }}</p>
                    <p class="text-gray-600">{{ tournament.location }}</p>
                    <p class="mt-2">{{ tournament.description }}</p>
                  </div>
                </div>
                <p v-else class="text-gray-500">No upcoming tournaments</p>
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