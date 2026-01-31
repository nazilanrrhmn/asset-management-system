import { createRouter, createWebHistory } from "vue-router";
import type { RouteRecordRaw } from "vue-router";
import DashboardView from "../views/DashboardView.vue";
import AssetList from "../views/assets/AssetList.vue";
import AssetDetail from "../views/assets/AssetDetail.vue";
import CategoryList from "../views/master/CategoryList.vue";
import LocationList from "../views/master/LocationList.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "dashboard",
    component: DashboardView,
  },
  {
    path: "/assets",
    name: "assets.index",
    component: AssetList,
  },
  {
    path: "/assets/:id",
    name: "assets.show",
    component: AssetDetail,
    props: true,
  },
  {
    path: "/categories",
    name: "categories.index",
    component: CategoryList,
  },
  {
    path: "/locations",
    name: "locations.index",
    component: LocationList,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
