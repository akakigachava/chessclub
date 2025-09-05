<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ user.role === 'admin' ? 'Admin Dashboard' : 'Member Dashboard' }}
        </h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div v-if="user.role === 'admin'" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <h3 class="text-lg font-medium mb-4">Pending Registrations</h3>
              <p>Go to <Link :href="route('admin.dashboard')" class="text-blue-500">Admin Dashboard</Link> to approve users</p>
            </div>
          </div>
          
          <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <div v-if="user.status === 'approved'">
                <h3 class="text-lg font-medium mb-4">Your Member QR Code</h3>
                <img :src="qrCodeUrl" alt="QR Code" class="mx-auto w-48 h-48">
                <p class="mt-4 text-center">Scan this QR code for identification</p>
              </div>
              
              <div v-else class="text-center py-8">
                <p class="text-lg text-yellow-600">Your account is pending approval</p>
                <p class="mt-2">Please wait for admin approval to access all features</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Head, Link } from '@inertiajs/vue3';
  import { computed } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  
  const user = computed(() => usePage().props.auth.user);
  const qrCodeUrl = computed(() => {
    return user.value ? `/api/user/${user.value.id}/qrcode` : '';
  });
  </script>