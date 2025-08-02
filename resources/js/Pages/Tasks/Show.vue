<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Task: {{ task.title }}
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Left: Task Details -->
                <div class="bg-white p-6 rounded shadow space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Task Details</h3>
                    <p><span class="font-medium">Title:</span> {{ task.title }}</p>
                    <p><span class="font-medium">Description:</span> {{ task.description }}</p>
                    <p><span class="font-medium">Status:</span> {{ task.status }}</p>
                    <p><span class="font-medium">Created At:</span> {{ new Date(task.created_at).toLocaleString() }}</p>

                    <div>
                        <h4 class="font-semibold mt-4 mb-2">Assigned User</h4>
                        <p v-if="task.user">{{ task.user.name }} ({{ task.user.email }})</p>
                        <p v-else class="text-gray-500">No user assigned</p>
                    </div>
                </div>

                <!-- Right: Timeline Section -->
                <div class="bg-white p-6 rounded shadow space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800">Timeline Updates</h3>

                        <div v-if="task.timelines.length === 0" class="text-gray-500">
                            No updates yet.
                        </div>

                        <ul class="space-y-4">
                            <li v-for="timeline in task.timelines" :key="timeline.id" class="border-b pb-2">
                                <p class="text-sm text-gray-800">{{ timeline.message }}</p>
                                <div class="text-xs text-gray-500 mt-1">
                                    — {{ timeline.user.name }} at {{ new Date(timeline.created_at).toLocaleString() }}
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Add Timeline Form -->
                    <form @submit.prevent="submit" class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            Add Update
                        </label>
                        <textarea
                            v-model="form.message"
                            class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            rows="3"
                            placeholder="Write an update..."
                        ></textarea>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm"
                        >
                            Post Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    task: Object,
    auth: Object,
    flash: Object
})

const form = useForm({
    message: ''
})

function submit() {
    form.post(route('tasks.timeline.store', props.task.id), {
        preserveScroll: true,
        onSuccess: () => form.reset('message'),
    })
}
</script>
