import { createRouter, createWebHistory } from "vue-router";
import CustomerForm from "../pages/customers/CustomerForm.vue";
import CustomerList from "../pages/customers/CustomerList.vue";
import TerritoryForm from "../pages/territories/TerritoryForm.vue";
import TerritoryList from "../pages/territories/TerritoryList.vue";

const routes = [
    { path: "/customers", component: CustomerList },
    { path: "/customers/create", component: CustomerForm },
    { path: "/customers/:id/edit", component: CustomerForm },
    { path: "/territories", component: TerritoryList },
    { path: "/territories/create", component: TerritoryForm },
    { path: "/territories/:id/edit", component: TerritoryForm },
    { path: "/", redirect: "/customers" },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
