<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use App\Models\DailyReport;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view employees', 'create employees', 'update employees', 'delete employees',
            'view customers', 'create customers', 'update customers', 'delete customers',
            'view tasks', 'create tasks', 'update tasks', 'delete tasks',
            'view reports', 'create reports', 'review reports',
            'view audit logs', 'manage settings', 'manage files', 'manage roles',
        ];

        collect($permissions)->each(fn ($name) => Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']));

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor', 'guard_name' => 'web']);
        $employeeRole = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
        $auditor = Role::firstOrCreate(['name' => 'Auditor', 'guard_name' => 'web']);

        $superAdmin->syncPermissions($permissions);
        $admin->syncPermissions($permissions);
        $manager->syncPermissions(['view employees', 'view customers', 'view tasks', 'create tasks', 'update tasks', 'view reports', 'review reports', 'manage files']);
        $supervisor->syncPermissions(['view employees', 'view customers', 'view tasks', 'create tasks', 'update tasks', 'view reports']);
        $employeeRole->syncPermissions(['view tasks', 'update tasks', 'create reports']);
        $auditor->syncPermissions(['view employees', 'view customers', 'view tasks', 'view reports', 'view audit logs']);

        $company = Company::firstOrCreate(
            ['slug' => 'dpo-demo'],
            ['uuid' => (string) str()->uuid(), 'name' => 'DPO Demo Company', 'plan' => 'enterprise', 'status' => 'active', 'timezone' => 'UTC', 'locale' => 'en']
        );

        $departments = collect([
            ['name' => 'Operations', 'code' => 'OPS', 'company_id' => $company->id],
            ['name' => 'Customer Success', 'code' => 'CS', 'company_id' => $company->id],
            ['name' => 'Field Service', 'code' => 'FS', 'company_id' => $company->id],
            ['name' => 'Finance', 'code' => 'FIN', 'company_id' => $company->id],
        ])->map(fn ($data) => Department::firstOrCreate(['code' => $data['code']], $data));

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@dpoerp.test'],
            ['company_id' => $company->id, 'name' => 'DPO Admin', 'password' => 'password', 'is_active' => true, 'email_verified_at' => now()]
        );
        $adminUser->update(['company_id' => $company->id, 'email_verified_at' => $adminUser->email_verified_at ?? now()]);
        $adminUser->assignRole('Super Admin');

        $managerUser = User::firstOrCreate(
            ['email' => 'manager@dpoerp.test'],
            ['company_id' => $company->id, 'name' => 'Ops Manager', 'password' => 'password', 'is_active' => true, 'email_verified_at' => now()]
        );
        $managerUser->update(['company_id' => $company->id, 'email_verified_at' => $managerUser->email_verified_at ?? now()]);
        $managerUser->assignRole('Manager');

        $managerEmployee = Employee::firstOrCreate(
            ['user_id' => $managerUser->id],
            ['company_id' => $company->id, 'department_id' => $departments[0]->id, 'employee_code' => 'EMP-00001', 'designation' => 'Operations Manager', 'joining_date' => now()->subYear(), 'phone' => '+1 555 0100', 'status' => 'active']
        );

        $employees = collect([$managerEmployee]);
        foreach (range(2, 8) as $index) {
            $user = User::firstOrCreate(
                ['email' => "employee{$index}@dpoerp.test"],
                ['company_id' => $company->id, 'name' => "Employee {$index}", 'password' => 'password', 'is_active' => true, 'email_verified_at' => now()]
            );
            $user->update(['company_id' => $company->id, 'email_verified_at' => $user->email_verified_at ?? now()]);
            $user->assignRole('Employee');
            $employees->push(Employee::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'company_id' => $company->id,
                    'department_id' => $departments->random()->id,
                    'employee_code' => 'EMP-'.str_pad((string) $index, 5, '0', STR_PAD_LEFT),
                    'designation' => collect(['Service Executive', 'CRM Associate', 'Field Engineer', 'Coordinator'])->random(),
                    'joining_date' => now()->subDays(rand(30, 700)),
                    'phone' => '+1 555 01'.str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                    'status' => 'active',
                ]
            ));
        }

        $customers = collect(['Northwind Logistics', 'Acme Corporate', 'BluePeak Services', 'Vertex Retail', 'Nexus Health'])
            ->map(fn ($name, $i) => Customer::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)).'@example.com'],
                ['company_id' => $company->id, 'name' => $name, 'phone' => '+1 555 20'.str_pad((string) $i, 2, '0', STR_PAD_LEFT), 'company_name' => $name, 'type' => collect(['regular', 'vip', 'corporate', 'lead'])->random(), 'status' => 'active', 'notes' => 'Seed CRM account.']
            ));

        foreach (range(1, 18) as $index) {
            $deadline = now()->addDays(rand(-4, 14))->setHour(rand(9, 17));
            $status = $deadline->isPast() ? 'overdue' : collect(['new', 'assigned', 'in_progress', 'on_hold', 'pending_approval'])->random();
            Task::firstOrCreate(
                ['title' => "Service operation task {$index}"],
                [
                    'company_id' => $company->id,
                    'description' => 'Coordinate service request, customer communication, and operational follow-up.',
                    'priority' => collect(Task::PRIORITIES)->random(),
                    'status' => $status,
                    'assigned_employee_id' => $employees->random()->id,
                    'customer_id' => $customers->random()->id,
                    'department_id' => $departments->random()->id,
                    'created_by' => $adminUser->id,
                    'deadline_at' => $deadline,
                    'progress' => rand(0, 95),
                ]
            );
        }

        DailyReport::firstOrCreate(
            ['employee_id' => $managerEmployee->id, 'report_date' => today()],
            ['company_id' => $company->id, 'completed_works' => 'Reviewed team pipeline and escalations.', 'time_spent_minutes' => 420, 'pending_work' => 'Approval follow-ups', 'review_status' => 'submitted']
        );
    }
}
