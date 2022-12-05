import "./bootstrap";
import { createApp } from "vue";
import MyComponent from "./MyComponent.vue";
import "bootstrap/dist/css/bootstrap.min.css";

const app = createApp({});

app.component("MyComponent", MyComponent);
app.mount("#root");
