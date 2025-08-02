<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                User Role Management
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="py-5">
                        <div
                            v-if="$page.props.flash?.message"
                            class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-700 border border-green-200"
                        >
                            {{ $page.props.flash.message }}
                        </div>

                        <table class="table-auto w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Email</th>
                                    <th class="px-4 py-2 text-left">Roles</th>
                                    <th class="px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id" class="border-b">
                                    <td class="px-4 py-2">{{ user.name }}</td>
                                    <td class="px-4 py-2">{{ user.email }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex flex-wrap gap-3">
                                            <label
                                                v-for="role in roles"
                                                :key="role.id"
                                                class="inline-flex items-center space-x-2"
                                            >
                                                <input
                                                    type="checkbox"
                                                    :value="role.name"
                                                    v-model="selectedRoles[user.id]"
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                />
                                                <span class="text-sm">{{ role.name }}</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2">
                                        <form @submit.prevent="updateRole(user.id, selectedRoles[user.id])">
                                            <button
                                                type="submit"
                                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                                            >
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const { users, roles, auth, errors } = defineProps({
    users: Array,
    roles: Array,
    auth: Object,
    errors: Object
})
const selectedRoles = ref({})

onMounted(() => {
  for (const user of users) {
    selectedRoles.value[user.id] = user.roles.map(role => role.name)
  }
})

function updateRole(userId, role) {
  router.post(route('admin.users.update-role', userId), {
    role
  })
}
</script>
