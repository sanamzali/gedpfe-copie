<script setup lang="ts">
import { ref } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import axios from 'axios'

// Déclaration des variables réactives pour le formulaire
const email = ref('')
const password = ref('')
const errors = ref<{ email?: string; password?: string }>({})

const submit = async () => {  
    try {
        errors.value = {}; // Réinitialiser les erreurs avant l'envoi  
        const response = await axios.post('/login', {  
            email: email.value,  
            password: password.value, 
        });  
        
        if (response.data.success) {  
            const userRole = response.data.user.role;
            if (userRole === 'admin') {
                window.location.href = '/admin/dashboard';
            } else if (userRole === 'user') {
                window.location.href = '/user/dashboard';
            }
        }
    } catch (error) {  
        if (error.response && error.response.data.errors) {  
            errors.value = error.response.data.errors;  
        } else {
            console.error('Erreur lors de la connexion:', error);
        }
    }
};
</script>

<template>
  <div class="w-full lg:grid lg:min-h-[600px] lg:grid-cols-2 xl:min-h-[800px]">
    <!-- Colonne gauche : Formulaire de connexion -->
    <div class="flex items-center justify-center py-12">
      <div class="mx-auto grid w-[350px] gap-6">
        <div class="grid gap-2 text-center">
          <h1 class="text-3xl font-bold">Login</h1>
        </div>
        <form @submit.prevent="submit" novalidate class="grid gap-4">
          <div class="grid gap-2">
            <Label for="email">Email</Label>
            <Input
              id="email"
              name="email"
              type="email"
              placeholder="m@example.com"
              v-model="email"
              :class="{ 'border-red-500': errors.email }"
              required
            />
            <span v-if="errors.email" class="text-red-500">{{ errors.email }}</span>
          </div>

          <div class="grid gap-2">
            <div class="flex items-center">
              <Label for="password">Password</Label>
              <a href="/forgot-password" class="ml-auto inline-block text-sm underline">
                Forgot your password?
              </a>
            </div>
            <Input
              id="password"
              name="password"
              type="password"
              v-model="password"
              :class="{ 'border-red-500': errors.password }"
              required
            />
            <span v-if="errors.password" class="text-red-500">{{ errors.password }}</span>
          </div>

          <Button type="submit" class="w-full">Login</Button>
        </form>
      </div>
    </div>

    <!-- Colonne droite : Image -->
    <div class="hidden bg-muted lg:block">
      <img
        src="../../images/gedimage.jpg"
        alt="Login Cover Image"
        class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
      />
    </div>
  </div>
</template>
