export const Users = [
    { name: "name", required: true, label: "اسم المستخدم", align: "left", field: "name", format: (val: any) => `${val}`, sortable: true, },
    { name: "email", align: "left", label: "البريد", field: "email", sortable: true, },
    { name: "phone", label: "رقم الهاتف", field: "phone", sortable: true, align: "left", },
    { name: "role", label: "الصلاحية", field: "role", sortable: true, align: "left", },
    { name: "account", label: "الفرع", field: "account", align: "left" },
    { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left" },
    { name: "options", label: "الإعدادات", field: "options" }
]

export const Roles = [
    { name: "name", required: true, label: "اسم الصلاحية", align: "left", field: "title", format: (val: any) => `${val}`, sortable: true },
    { name: "permissions", align: "left", label: "عدد الصلاحيات", field: "permissions", format: (val: any) => `${val.length}`, },
    { name: "users", label: "عدد المستخدمين", field: "users", align: "left", format: (val: any) => `${val.length}`, },
    { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
]

export const Permissions = [
    { name: "details", required: true, label: "اسم أذن", align: "left", field: "details", sortable: true },
    { name: "title", align: "left", label: " رابط الصلاحية", field: "title" },
    { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
    { name: "options", label: "الإعدادات", field: "options" }
]

export const StudentsColumns = [
    { name: "name", required: true, label: "اسم طالب", align: "left", field: "name", sortable: true },
    { name: "age", align: "left", label: "تاريخ الميلاد", field: "age" },
    { name: "ageNum", align: "left", label: "العمر", field: "ageNum" },
    { name: "email", label: "البريد", field: "email" },
    { name: "phone", label: "رقم الهاتف", field: "phone" },
    { name: "address", align: "left", label: "العنوان", field: "address", format: (val: any) => `${val.length > 30 ? val.split("", 30).join("") + "..." : val}` },    { name: "level", label: "الفصل الدراسي", field: "level" },
    { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
    { name: "photo", label: "الصورة", field: "photo" },
    { name: "options", label: "الإعدادات", field: "options" }
]

export const StudentsLevels = [
    { name: "name", required: true, label: "اسم طالب", align: "left", field: "name", sortable: true },
    { name: "age", align: "left", label: "تاريخ الميلاد", field: "age" },
    { name: "ageNum", align: "left", label: "العمر", field: "ageNum" },
    { name: "address", align: "left", label: "العنوان", field: "address", format: (val: any) => `${val.length > 30 ? val.split("", 30).join("") + "..." : val}` },    { name: "level", label: "الفصل الدراسي", field: "level" },
    { name: "email", label: "البريد", field: "email" },
    { name: "phone", label: "رقم الهاتف", field: "phone" },
]

export const TeachersColumns = [
    { name: "name", required: true, label: "اسم المعلم", align: "left", field: "name", sortable: true },
    { name: "phone", label: "رقم الهاتف", field: "phone", align: "left" },
    { name: "email", label: "البريد", field: "email", align: "left" },
    { name: "address", align: "left", label: "العنوان", field: "address" },
    { name: "material", label: "عدد المواد", field: "material", align: "left" },
    { name: "level", label: "عدد الفصول", field: "level", align: "left" },
    { name: "details", label: "التفاصيل", field: "details", align: "left" },
    { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
]

export const LevelColumns = [
    { name: "name", required: true, label: "اسم الفصل", align: "left", field: "name", sortable: true },
    { name: "details", align: "left", label: "التفاصيل", field: "details" },
    { name: "material", label: "عدد المواد", field: "material", align: "left" },
    { name: "teacher", label: "عدد المعلمين", field: "teacher", align: "left" },
    { name: "student", label: "عدد الطلاب", field: "student", align: "left" },
    { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
]

export const MaterialColumns = [
    { name: "name", required: true, label: "اسم المادة الدراسية", align: "left", field: "name", sortable: true },
    { name: "max_degree", label: "أعلى درجة", field: "max_degree", align: "left" },
    { name: "min_degree", label: "أقل درجة", field: "min_degree", align: "left" },
    { name: "details", align: "left", label: "التفاصيل", field: "details", format: (val: any) => `${val.length > 30 ? val.split("", 30).join("") + "..." : val}` },
    { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
]

export const TutorialColumns = [
    { name: "title", required: true, label: "عنوان الدرس", align: "left", field: "title", sortable: true },
    { name: "material", label: " المادة الدراسية", field: "material", align: "left" },
    { name: "level", label: "الفصل الدراسي", field: "level", align: "left" },
    { name: "teacher", align: "left", label: "المعلم", field: "teacher" },
    { name: "user", align: "left", label: "المستخدم", field: "user" },
    { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
]
