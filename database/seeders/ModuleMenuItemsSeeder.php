<?php

namespace Database\Seeders;

use App\Models\ModuleMenuItem;
use Illuminate\Database\Seeder;

class ModuleMenuItemsSeeder extends Seeder
{
    public function run()
    {
        ModuleMenuItem::query()->where('module_key', 'platform')->delete();

        $items = [
            // clinic_admin
            [
                'module_key' => 'clinic_admin',
                'item_key' => 'clinic_admin.doctors_ratings',
                'route_name' => 'admin.doctors.ratings',
                'label_en' => 'Doctors ratings',
                'label_ar' => 'تقييمات الأطباء',
                'icon_class' => 'fa-solid fa-star-half-stroke',
                'app_types' => [1, 7, 11],
                'sort_order' => 10,
            ],
            [
                'module_key' => 'clinic_admin',
                'item_key' => 'clinic_admin.departments',
                'route_name' => 'departments',
                'label_en' => 'Departments',
                'label_ar' => 'الأقسام',
                'icon_class' => 'fa-solid fa-layer-group',
                'app_types' => [1, 7, 11],
                'sort_order' => 20,
            ],
            [
                'module_key' => 'clinic_admin',
                'item_key' => 'clinic_admin.offers',
                'route_name' => 'offers',
                'label_en' => 'Manage Offers',
                'label_ar' => 'إدارة العروض',
                'icon_class' => 'fa-solid fa-tags',
                'app_types' => [1, 7, 11],
                'sort_order' => 30,
            ],
            [
                'module_key' => 'clinic_admin',
                'item_key' => 'clinic_admin.specialties',
                'route_name' => 'specialties',
                'label_en' => 'Manage available specialties',
                'label_ar' => 'إدارة التخصصات المتاحة',
                'icon_class' => 'fa-solid fa-stethoscope',
                'app_types' => [1, 7, 11],
                'sort_order' => 40,
            ],
            [
                'module_key' => 'clinic_admin',
                'item_key' => 'clinic_admin.branches',
                'route_name' => 'branches',
                'label_en' => 'Manage Branch',
                'label_ar' => 'إدارة الفروع',
                'icon_class' => 'fa-solid fa-code-branch',
                'app_types' => [1, 11],
                'sort_order' => 50,
            ],
            [
                'module_key' => 'clinic_admin',
                'item_key' => 'clinic_admin.supervisor',
                'route_name' => 'clinic.supervisor',
                'label_en' => 'SuperVisor Management',
                'label_ar' => 'إدارة المشرفين',
                'icon_class' => 'fa-solid fa-user-shield',
                'app_types' => [1, 7, 11],
                'sort_order' => 60,
            ],
            [
                'module_key' => 'clinic_admin',
                'item_key' => 'clinic_admin.contact_us',
                'route_name' => 'contactUs',
                'label_en' => 'Complaints Box',
                'label_ar' => 'صندوق الشكاوى',
                'icon_class' => 'fa-solid fa-comments',
                'app_types' => [1, 7, 11],
                'sort_order' => 70,
            ],

            // reception
            [
                'module_key' => 'reception',
                'item_key' => 'reception.appointments',
                'route_name' => 'appointments',
                'label_en' => 'Appointments list',
                'label_ar' => 'قائمة المواعيد',
                'icon_class' => 'fa-solid fa-calendar-check',
                'app_types' => [2],
                'sort_order' => 10,
            ],
            [
                'module_key' => 'reception',
                'item_key' => 'reception.add_patient',
                'route_name' => 'add-patient',
                'label_en' => 'Add patient',
                'label_ar' => 'إضافة مريض',
                'icon_class' => 'fa-solid fa-user-plus',
                'app_types' => [2],
                'sort_order' => 20,
            ],
            [
                'module_key' => 'reception',
                'item_key' => 'reception.add_appointment',
                'route_name' => 'add-appointment',
                'label_en' => 'Add appointment',
                'label_ar' => 'إضافة موعد',
                'icon_class' => 'fa-solid fa-calendar-plus',
                'app_types' => [2],
                'sort_order' => 30,
            ],
            [
                'module_key' => 'reception',
                'item_key' => 'reception.chat_list',
                'route_name' => 'chatList',
                'label_en' => 'Chat list',
                'label_ar' => 'قائمة المحادثات',
                'icon_class' => 'fa-solid fa-comments',
                'app_types' => [2],
                'sort_order' => 40,
            ],

            // points / loyalty
            [
                'module_key' => 'points',
                'item_key' => 'points.dashboard',
                'route_name' => 'loyalty.dashboard',
                'label_en' => 'Loyalty program',
                'label_ar' => 'برنامج الولاء',
                'icon_class' => 'fa-solid fa-gift',
                'app_types' => [1, 7, 11],
                'sort_order' => 10,
            ],
            [
                'module_key' => 'points',
                'item_key' => 'points.redemptions',
                'route_name' => 'loyalty.redemptions',
                'label_en' => 'Loyalty program',
                'label_ar' => 'برنامج الولاء',
                'icon_class' => 'fa-solid fa-gift',
                'app_types' => [2],
                'sort_order' => 10,
            ],
        ];

        foreach ($items as $item) {
            ModuleMenuItem::updateOrCreate(
                ['item_key' => $item['item_key']],
                array_merge($item, ['is_active' => true])
            );
        }
    }
}
