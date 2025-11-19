import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
   // server: {
   //   hmr: {
   //     host: "localhost:8000",
   //   },
   // },
   plugins: [
      laravel({
         input: [
            "resources/sass/app.scss",
            "resources/css/app.css",
            "resources/css/admin.css",
            "resources/js/app.js",
         ],
         refresh: true,
      }),
   ],
   resolve: {
      alias: {
         "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
      },
   },
});
