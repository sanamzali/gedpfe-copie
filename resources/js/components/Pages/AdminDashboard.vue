<script setup lang="ts">
import { ref } from "vue";
import { Bell, CircleUser, Home, LineChart, Menu, Package, Users, Search, ShoppingCart } from "lucide-vue-next";
import { Badge } from "@/components/ui/badge";
import { Input } from "@/components/ui/input";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet";

const showMenu = ref(false);
const currentPage = ref(window.location.pathname);

const toggleMenu = () => {
  showMenu.value = !showMenu.value;
};

const logout = () => {
  console.log("Logout action");
};
</script>

<template>
  <div class="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]">
    <!-- Sidebar -->
    <aside class="flex flex-col h-screen border-r bg-muted/40 p-4 overflow-y-auto">
      <div class="flex items-center justify-between px-4 py-2 border-b">
        <span class="font-bold text-lg">Admin Inc</span>
        <Sheet>
          <SheetTrigger as="button">
            <Menu class="h-6 w-6" />
          </SheetTrigger>
          <SheetContent side="left">
            <nav class="flex flex-col gap-y-2 mt-4">
              <a href="/dashboard" class="flex items-center gap-4 px-3 py-2 rounded-lg" :class="{ 'bg-blue-500 text-white': currentPage === '/dashboard' }">
                <Home class="h-5 w-5" />
                Dashboard
              </a>
              <a href="/" class="flex items-center gap-4 px-3 py-2 rounded-lg" :class="{ 'bg-blue-500 text-white': currentPage === '/' }">
                <ShoppingCart class="h-5 w-5" />
                Home
                <Badge class="ml-auto h-6 w-6 flex items-center justify-center rounded-full bg-blue-500 text-white">6</Badge>
              </a>
              <a href="#" class="flex items-center gap-4 px-3 py-2 rounded-lg hover:bg-accent">
                <Package class="h-5 w-5" />
                Products
              </a>
              <a href="#" class="flex items-center gap-4 px-3 py-2 rounded-lg hover:bg-accent">
                <Users class="h-5 w-5" />
                Customers
              </a>
              <a href="#" class="flex items-center gap-4 px-3 py-2 rounded-lg hover:bg-accent">
                <LineChart class="h-5 w-5" />
                Analytics
              </a>
            </nav>
          </SheetContent>
        </Sheet>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex flex-col flex-1">
      <header class="flex items-center justify-between bg-white border-b p-4">
        <div class="relative w-full max-w-md">
          <Input type="text" placeholder="Search products..." class="w-full p-2 pl-10 border rounded-lg focus:outline-none" />
          <Search class="absolute left-3 top-3 h-4 w-4 text-gray-500" />
        </div>
        <div class="flex items-center gap-4">
          <Bell class="h-6 w-6 text-gray-500" />
          <div class="relative">
            <button @click="toggleMenu">
              <CircleUser class="h-6 w-6 text-gray-500 cursor-pointer" />
            </button>
            <div v-if="showMenu" class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md border">
              <ul class="p-2 space-y-1">
                <li><a href="#" class="block px-3 py-2 hover:bg-gray-200">My Account</a></li>
                <li><a href="#" class="block px-3 py-2 hover:bg-gray-200">Settings</a></li>
                <li><a href="#" class="block px-3 py-2 hover:bg-gray-200">Support</a></li>
                <li class="border-t"><a href="#" class="block px-3 py-2 text-red-500 hover:bg-gray-200" @click="logout">Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </header>
      <main class="p-6">
        <h2 class="text-xl font-bold">Inventory</h2>
        <div class="flex flex-1 items-center justify-center rounded-lg border border-dashed shadow-sm">
          <slot/>
        </div>
      </main>
    </div>
  </div>
</template>
