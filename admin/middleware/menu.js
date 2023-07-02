export default function(context) {
    const { $auth, route, redirect } = context
    
    if ($auth.user) {
        const permissions = $auth.user.permissions
        const roles = $auth.user.roles
        
        if (roles[0].name !== 'Super Admin') {
            const menus = permissions.filter(function (permission) {
                return permission.name.includes("_access");
            }).map(function (item) {
                return item.name.replace('_access', '')
            })

            if (menus.length) {
                const adminRoutes = []

                menus.forEach(menu => {
                    if (menu === 'report') {
                        adminRoutes.push('reports-sales');
                        adminRoutes.push('reports-expenses');
                    }
                    else if (menu === 'location') {
                        adminRoutes.push('locations');
                        adminRoutes.push('locations-create');
                        adminRoutes.push('locations-properties');
                        adminRoutes.push('locations-properties-create');
                    }
                    else if (menu === 'reservation') {
                        adminRoutes.push('reservations');
                        adminRoutes.push('reservations-create');
                        adminRoutes.push('reservations-id');
                        adminRoutes.push('reservations-id-update');
                    }
                    else if (menu === 'receipt') {
                        adminRoutes.push('receipts');
                        adminRoutes.push('receipts-create');
                    }
                    else if (menu === 'calendar' || menu === 'dashboard') {
                        adminRoutes.push(menu);
                    }
                    else {
                        adminRoutes.push(menu + 's');
                    }
                });
         
                if (!adminRoutes.includes(route.name)) {
                    redirect('/' + adminRoutes[0].replace('-', '/'))
                }
            }
        } 
    }
}
