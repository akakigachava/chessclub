<script setup>
import { usePage, Link, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3';


defineProps({
  users: {
    type: Array,
    required: true
  }
})

const { props: page } = usePage()
const authUser = page.auth.user

const editingUser = ref(null)
const showEditForm = ref(false)


const searchQuery = ref('')


const editForm = useForm({
  id: null,
  name: '',
  rating: ''
})

const filteredUsers = computed(() => {
  if (!searchQuery.value) {
    return page.users
  }
  
  const query = searchQuery.value.toLowerCase().trim()
  return page.users.filter(user => {
    return user.name.toLowerCase().includes(query) ||
           user.rating.toString().includes(query)
  })
})

const openEditForm = (user) => {
  editingUser.value = user
  editForm.id = user.id
  editForm.name = user.name
  editForm.rating = user.rating
  showEditForm.value = true
}

const closeEditForm = () => {
  showEditForm.value = false
  editingUser.value = null
  editForm.reset()
}

const submitEdit = () => {
  editForm.put(`/users/${editForm.id}`, {
    onSuccess: () => {
      closeEditForm()
    }
  })
}


const clearSearch = () => {
  searchQuery.value = ''
}

const toggleVip = (userId) => {
  router.patch(`/admin/users/${userId}/toggle-vip`, {}, {
    preserveScroll: true,
  });
};
</script>

<template>
  <div class="min-h-screen bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-6">კლუბის წევრების რეიტინგ სია</h1>
    
    
    <div class="mb-6 bg-white p-4 rounded-lg shadow">
      <div class="flex items-center gap-4">
        <div class="flex-1">
          <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
            ძიება სახელით ან რეიტინგით
          </label>
          <div class="relative">
            <input
              id="search"
              v-model="searchQuery"
              type="text"
              placeholder="შეიყვანეთ სახელი ან რეიტინგი..."
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
            <div v-if="searchQuery" class="absolute right-2 top-1/2 transform -translate-y-1/2">
              <button
                @click="clearSearch"
                class="text-gray-400 hover:text-gray-600 p-1"
                title="გაასუფთავე ძიება"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
      
    
      <div v-if="searchQuery" class="mt-3 text-sm text-gray-600">
        <span v-if="filteredUsers.length > 0">
          ნაპოვნია {{ filteredUsers.length }} შედეგი "{{ searchQuery }}" ძიებისთვის
        </span>
        <span v-else class="text-red-600">
          არ არის ნაპოვნი შედეგები "{{ searchQuery }}" ძიებისთვის
        </span>
      </div>
    </div>

   
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="w-full border-collapse">
        <thead class="bg-gray-200 text-left">
          <tr>
            <th class="p-3">#</th>
            <th class="p-3">სახელი</th>
            <th class="p-3">რეიტინგი</th>
            <th class="p-3">სტატუსი</th>
            <th v-if="authUser?.role === 'admin'" class="p-3">მოქმედებები</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="filteredUsers.length === 0 && searchQuery" class="border-b">
            <td colspan="5" class="p-8 text-center text-gray-500">
              <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <p class="text-lg font-medium">შედეგები ვერ მოიძებნა</p>
                <p class="text-sm">სცადეთ სხვა ძიების ტერმინი</p>
              </div>
            </td>
          </tr>
          
          <tr 
            v-for="(user, index) in filteredUsers" 
            :key="user.id" 
            :class="{ 'bg-yellow-50': user.is_vip }"
            class="border-b hover:bg-gray-50"
          >
            <td class="p-3">{{ index + 1 }}</td>
            <td class="p-3">
              <div class="flex items-center gap-2">
                <span v-if="searchQuery" v-html="highlightSearchTerm(user.name, searchQuery)"></span>
                <span v-else>{{ user.name }}</span>
                <span 
                  v-if="user.is_vip" 
                  class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-400 to-yellow-500 text-white shadow-sm"
                >
                  ⭐ 
                </span>
              </div>
            </td>
            <td class="p-3 font-semibold">
              <span v-if="searchQuery" v-html="highlightSearchTerm(user.rating.toString(), searchQuery)"></span>
              <span v-else>{{ user.rating }}</span>
            </td>
            <td class="p-3">
              <span 
                :class="user.is_vip ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'"
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium"
              >
                {{ user.is_vip ? 'კლუბის საპატიო წევრი' : 'კლუბის წევრი' }}
              </span>
            </td>
            
            <td v-if="authUser?.role === 'admin'" class="p-3">
              <div class="flex items-center gap-2">
                <button 
                  @click="toggleVip(user.id)"
                  :class="user.is_vip 
                    ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' 
                    : 'bg-gradient-to-r from-yellow-400 to-yellow-500 text-white hover:from-yellow-500 hover:to-yellow-600 shadow-md hover:shadow-lg'"
                  class="px-3 py-1 rounded-lg text-sm font-medium transition-all duration-200"
                >
                  {{ user.is_vip ? 'საპატიო წევრობის მოხსნა' : 'საპატიო წევრობის მინიჭება' }}
                </button>
                <button 
                  @click="openEditForm(user)" 
                  class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition-colors"
                >
                  მონაცემთა შეცვლა
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="showEditForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg w-96">
        <h2 class="text-xl font-bold mb-4">მონაცემთა შეცვლა</h2>
        
        <form @submit.prevent="submitEdit">
          <div class="mb-4">
            <label class="block text-sm font-bold mb-2">სახელი:</label>
            <input 
              v-model="editForm.name"
              type="text"
              class="w-full p-2 border rounded"
              required
            >
            <div v-if="editForm.errors.name" class="text-red-500 text-sm">
              {{ editForm.errors.name }}
            </div>
          </div>
          
          <div class="mb-4">
            <label class="block text-sm font-bold mb-2">რეიტინგი:</label>
            <input 
              v-model="editForm.rating"
              type="number"
              class="w-full p-2 border rounded"
              required
            >
            <div v-if="editForm.errors.rating" class="text-red-500 text-sm">
              {{ editForm.errors.rating }}
            </div>
          </div>
          
          <div class="flex justify-end gap-2">
            <button 
              type="button"
              @click="closeEditForm"
              class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition-colors"
            >
              გაუქმება
            </button>
            <button 
              type="submit"
              :disabled="editForm.processing"
              class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors disabled:opacity-50"
            >
              {{ editForm.processing ? 'იცვლება...' : 'შენახვა' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    highlightSearchTerm(text, searchTerm) {
      if (!searchTerm) return text
      
      const regex = new RegExp(`(${searchTerm})`, 'gi')
      return text.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>')
    }
  }
}
</script>