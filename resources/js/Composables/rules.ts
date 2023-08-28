import { type LoginType, type StudentData } from "@/types"
import { ref } from "vue"

export const useForms = () => {

    const login = ref<LoginType>({ email: null, password: null, remember: false, })
    const register = ref<StudentData>({ email: null, password: null, age: null, details: null, id: null, name: null, level_id: null, password_confirmation: null, phone: null, photo: null, type: null })
    const rules = {
        required: [(val: any) => (val && val.length > 0) || 'لا تترك هذا الحقل فارغا من فضلك'],
        selected: [(val: any) => (val != null) || 'اختر بيانات لهذا الحقل من فضلك'],
    }
    return { login, rules, register }
}
