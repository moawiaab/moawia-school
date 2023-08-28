import { defineStore } from "pinia";
import axios from "axios";
import type { StudentData } from "@/types";

export const useAuth = defineStore("auth-store", {
    state: () => ({
        entry: <StudentData>{},
        userData: {
            id: null,
            name: null,
            email: null,
            phone: null,
            account: null,
            role: null,
            created_at: null,
        },
        can : [],
        loading: false,
        splitterModel : 50,
    }),
    getters: {
        user: (state) => state.userData
    },
    actions: {

        storeData(params: any) {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    // .post('login', this.entry)
                    .request({ baseURL: "/", url: "login", method: "post", params: params })
                    .then((response) => {
                        this.setRoles()
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    })

                this.loading = false;

            });
        },
        setRoles() {
            axios.get("abilities").then((response) => {
                this.can = response.data.data
                this.userData = response.data.user;
            });
        },

    },
    persist : true
});
