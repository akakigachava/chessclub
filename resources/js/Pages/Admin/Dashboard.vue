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
          ადმინის გვერდი
        </h2>
        <p class="text-slate-300 mt-2">მართეთ კლუბის წევრების რეგისტრაცია, ტურნირები და კლუბის აქტივობები</p>
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

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
          <div class="flex border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50">
            <button @click="activeTab = 'members'" 
                    :class="{'border-b-4 border-blue-500 text-blue-600 bg-white': activeTab === 'members', 'text-slate-600 hover:text-blue-500': activeTab !== 'members'}" 
                    class="px-8 py-4 font-bold text-lg transition-all duration-300 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
              </svg>
              კლუბის წევრები
            </button>
            <button @click="activeTab = 'tournaments'" 
                    :class="{'border-b-4 border-blue-500 text-blue-600 bg-white': activeTab === 'tournaments', 'text-slate-600 hover:text-blue-500': activeTab !== 'tournaments'}" 
                    class="px-8 py-4 font-bold text-lg transition-all duration-300 flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
              </svg>
              ტურნირები
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
                <h3 class="text-2xl font-bold text-slate-800">რეგისტრაციის მოთხოვნები</h3>
              </div>
              
              <div v-if="pendingUsers && pendingUsers.length" class="overflow-x-auto">
                <table class="min-w-full">
                  <thead class="bg-gradient-to-r from-slate-100 to-slate-200">
                    <tr>
                      <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider rounded-tl-lg">სახელი</th>
                      <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">ელ-ფოსტა</th>
                      <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">ტელეფონის ნომერი</th>
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
                          დადასტურება
                        </button>
                        <button @click="rejectUser(user.id)" 
                                class="bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                          უარყოფა
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
                <p class="text-xl font-medium text-slate-500">რეგისტრაციის თხოვნები არაა</p>
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
                <h3 class="text-2xl font-bold text-slate-800">კლუბის წევრები</h3>
              </div>
              
              <div v-if="approvedUsers && approvedUsers.length" class="overflow-x-auto">
                <table class="min-w-full">
                  <thead class="bg-gradient-to-r from-slate-100 to-slate-200">
                    <tr>
                      <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider rounded-tl-lg">სახელი</th>
                      <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">ელ-ფოსტა</th>
                      <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">ტელეფონის ნომერი</th>
                      <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider">საწევროს სტატუსი</th>
                      <th class="px-6 py-4 text-left text-sm font-bold text-slate-700 uppercase tracking-wider rounded-tr-lg">QR კოდი</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    <tr v-for="user in approvedUsers" :key="user.id" class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-200">
                      <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">{{ user.name }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ user.email }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ user.phone || 'N/A' }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ user.membership_type }}</td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <a :href="`/api/user/${user.id}/qrcode`" 
                           download 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-medium rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                          </svg>
                          გადმოწერეთ QR
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
                <p class="text-xl font-medium text-slate-500">დადასტრებული სტატუსის კლუბის წევრები ჯერ არ არიან</p>
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
                <h3 class="text-2xl font-bold text-slate-800">შექმენით ახალი ტურნირი</h3>
              </div>
              
              <form @submit.prevent="createTournament" class="space-y-6">
                <div>
                  <label class="block text-slate-700 text-sm font-bold mb-2" for="name">
                    ტურნირის სახელი
                  </label>
                  <input v-model="tournamentForm.name" 
                         id="name" 
                         type="text" 
                         required
                         class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                </div>
                
                <div>
                  <label class="block text-slate-700 text-sm font-bold mb-2" for="start_date">
                    ტურნირის დაწყების თარიღი
                  </label>
                  <input v-model="tournamentForm.start_date" 
                         id="start_date" 
                         type="datetime-local" 
                         required
                         class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                </div>
                
                <div>
                  <label class="block text-slate-700 text-sm font-bold mb-2" for="location">
                    ადგილმდებაროეობა
                  </label>
                  <input v-model="tournamentForm.location" 
                         id="location" 
                         type="text" 
                         required
                         class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                </div>
                
                <div>
                  <label class="block text-slate-700 text-sm font-bold mb-2" for="description">
                    ტურნირის დეტალები(აღწერა)
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
                  {{ tournamentForm.processing ? 'იქმნება...' : 'ტურნირის შექმნა' }}
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
                <h3 class="text-2xl font-bold text-slate-800">დაგეგმილი ტურნირები</h3>
              </div>
              
              <div v-if="tournaments && tournaments.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="tournament in tournaments" :key="tournament.id" 
                     class="bg-gradient-to-br from-white to-slate-50 border-2 border-slate-200 rounded-2xl p-6 shadow-lg hover:shadow-2xl hover:border-purple-300 transition-all duration-300 transform hover:-translate-y-2">

                  <!-- Header with logo + status -->
                  <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                      <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                      </svg>
                    </div>
                    <div class="w-3 h-3 bg-green-400 rounded-full shadow-lg"></div>
                  </div>

                  <!-- Tournament info -->
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

                  <p class="text-slate-700 leading-relaxed mb-4">{{ tournament.description }}</p>

                  <!-- Action buttons -->
                  <div class="flex space-x-3">
                    <!-- Edit button -->
                    <button @click="editTournament(tournament)"
                            class="flex items-center px-3 py-1.5 bg-blue-500 text-white text-sm rounded-lg shadow-md hover:bg-blue-600 transition">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                      რედაქტირება
                    </button>

                    <!-- Delete button -->
                    <button @click="deleteTournament(tournament.id)"
                            class="flex items-center px-3 py-1.5 bg-red-500 text-white text-sm rounded-lg shadow-md hover:bg-red-600 transition">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      წაშლა
                    </button>
                  </div>
                </div>
              </div>
              <div v-else class="text-center py-12">
                <div class="w-16 h-16 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                  <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <p class="text-xl font-medium text-slate-500">დაგეგმილი ტურნირები არ არის</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Edit Tournament Modal -->
        <div v-if="editingTournament" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div class="bg-white rounded-2xl p-8 max-w-md w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="flex justify-between items-center mb-6">
              <h3 class="text-2xl font-bold text-slate-800">ტურნირის რედაქტირება</h3>
              <button @click="closeEditModal" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
            
            <form @submit.prevent="updateTournament" class="space-y-6">
              <div>
                <label class="block text-slate-700 text-sm font-bold mb-2" for="edit_name">
                  ტურნირის სახელი
                </label>
                <input v-model="editForm.name" 
                       id="edit_name" 
                       type="text" 
                       required
                       class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                <div v-if="editForm.errors.name" class="text-red-500 text-sm mt-1">{{ editForm.errors.name }}</div>
              </div>
              
              <div>
                <label class="block text-slate-700 text-sm font-bold mb-2" for="edit_start_date">
                  ტურნირის დაწყების თარიღი
                </label>
                <input v-model="editForm.start_date" 
                       id="edit_start_date" 
                       type="datetime-local" 
                       required
                       class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                <div v-if="editForm.errors.start_date" class="text-red-500 text-sm mt-1">{{ editForm.errors.start_date }}</div>
              </div>
              
              <div>
                <label class="block text-slate-700 text-sm font-bold mb-2" for="edit_location">
                  ადგილმდებაროეობა
                </label>
                <input v-model="editForm.location" 
                       id="edit_location" 
                       type="text" 
                       required
                       class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm">
                <div v-if="editForm.errors.location" class="text-red-500 text-sm mt-1">{{ editForm.errors.location }}</div>
              </div>
              
              <div>
                <label class="block text-slate-700 text-sm font-bold mb-2" for="edit_description">
                  ტურნირის დეტალები(აღწერა)
                </label>
                <textarea v-model="editForm.description" 
                          id="edit_description" 
                          rows="4"
                          class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-slate-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm resize-none"></textarea>
                <div v-if="editForm.errors.description" class="text-red-500 text-sm mt-1">{{ editForm.errors.description }}</div>
              </div>
              
              <div class="flex space-x-4">
                <button type="submit" 
                        :disabled="editForm.processing"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg hover:shadow-xl">
                  <span v-if="editForm.processing">განახლება...</span>
                  <span v-else>განახლება</span>
                </button>
                <button type="button" 
                        @click="closeEditModal"
                        class="flex-1 bg-slate-300 hover:bg-slate-400 text-slate-700 font-bold py-3 px-6 rounded-xl transition-all duration-200">
                  გაუქმება
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Delete Tournament Confirmation Modal -->
        <div v-if="deletingTournament" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl">
            <div class="text-center">
              <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
              </div>
              <h3 class="text-xl font-bold text-slate-800 mb-2">ტურნირის წაშლა</h3>
              <p class="text-slate-600 mb-6">დარწმუნებული ხართ, რომ გსურთ ამ ტურნირის წაშლა? ეს ქმედება შეუქცევადია.</p>
              <div class="flex space-x-4">
                <button @click="confirmDelete" 
                        :disabled="deleteForm.processing"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                  <span v-if="deleteForm.processing">იშლება...</span>
                  <span v-else>წაშლა</span>
                </button>
                <button @click="cancelDelete"
                        class="flex-1 bg-slate-300 hover:bg-slate-400 text-slate-700 font-bold py-3 px-6 rounded-xl transition-all duration-200">
                  გაუქმება
                </button>
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

// Edit/Delete state management
const editingTournament = ref(null);
const deletingTournament = ref(null);

// User management functions
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

// Tournament forms
const tournamentForm = useForm({
  name: '',
  start_date: '',
  location: '',
  description: '',
});

const editForm = useForm({
  id: null,
  name: '',
  start_date: '',
  location: '',
  description: '',
});

const deleteForm = useForm({});

// Tournament management functions
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

const editTournament = (tournament) => {
  editingTournament.value = tournament;
  editForm.id = tournament.id;
  editForm.name = tournament.name;
  // Format the date for datetime-local input
  if (tournament.start_date) {
    const date = new Date(tournament.start_date);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    editForm.start_date = `${year}-${month}-${day}T${hours}:${minutes}`;
  }
  editForm.location = tournament.location;
  editForm.description = tournament.description;
};

const closeEditModal = () => {
  editingTournament.value = null;
  editForm.reset();
  editForm.clearErrors();
};

const updateTournament = () => {
  editForm.put(route('admin.tournaments.update', { tournament: editForm.id }), {
    preserveScroll: true,
    onSuccess: () => {
      closeEditModal();
    },
    onError: (errors) => {
      console.error('Error updating tournament:', errors);
    }
  });
};

const deleteTournament = (tournamentId) => {
  deletingTournament.value = tournamentId;
};

const cancelDelete = () => {
  deletingTournament.value = null;
  deleteForm.clearErrors();
};

const confirmDelete = () => {
  deleteForm.delete(route('admin.tournaments.destroy', { tournament: deletingTournament.value }), {
    preserveScroll: true,
    onSuccess: () => {
      deletingTournament.value = null;
    },
    onError: (errors) => {
      console.error('Error deleting tournament:', errors);
    }
  });
};

// Utility functions
const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return date.toLocaleString('ka-GE', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};
</script>