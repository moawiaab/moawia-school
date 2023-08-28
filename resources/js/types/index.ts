export interface LoginType {
    email: string | null;
    password: string | null;
    remember: boolean | false,
}

export interface ApiRouter {
    router: string;
}
export interface User {
    name: string | null;
    email: string | null;
    password: string | null;
    phone: string | null;
    role_id: number | null;
    password_confirmation: string | null;
}

export interface Role {
    title: string | null;
    permissions: [];
    users: [];
}

export interface Permission {
    title: string,
    details: string,
}

export interface StudentData {
    id: number | null;
    name: string | null;
    age: string | null;
    email: string | null | any;
    phone: string | null;
    password: string | null;
    password_confirmation: string | null;
    details: string | null;
    type: number | null;
    level_id: number | null;
    photo: File | null
}

export interface TeacherData {
    id: number | null;
    name: string;
    address: string | null;
    email: string | null | any;
    phone: string;
    password: string;
    password_confirmation: string;
    details: string;
}

export interface LevelData {
    id: number | null;
    name: string;
    details: string;
}

export interface MaterialData {
    id: number | null;
    name: string;
    details: string;
    max_degree : number;
    min_degree : number;
}

export interface ListType {
    budgets: Array<[]>;
    teachers: Array<[]>;
    materials: Array<[]>;
    students: Array<[]>;
}

export interface Material {
    level_id: number | null;
    material_id: number | null;
    teacher_id: number | null;
}

export interface TutorialData {
    id: string;
    title: string;
    url: string;
    details: string;
    audio: any;
}

