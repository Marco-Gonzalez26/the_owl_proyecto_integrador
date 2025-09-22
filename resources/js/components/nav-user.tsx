import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import { useInitials } from '@/hooks/use-initials';
import { useIsMobile } from '@/hooks/use-mobile';
import { SharedData } from '@/types';
import { Link, router, usePage } from '@inertiajs/react';
import { LogOut, Store } from 'lucide-react';
import { Avatar, AvatarFallback, AvatarImage } from './ui/avatar';

export function NavUser() {
    const { auth } = usePage<SharedData>().props;
    const { state } = useSidebar();
    const isMobile = useIsMobile();
    const getInitials = useInitials();
    const logout = async () => {
        // Logout del usuario
        try {
            await router.post(route('logout'));
            return;
        } catch (error) {
            console.log(error);
        }
    };
    return (
        <SidebarMenu>
            <SidebarMenuItem>
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Avatar className="size-8 overflow-hidden rounded-full">
                            <AvatarImage src={auth.user.avatar} alt={auth.user.name} />
                            <AvatarFallback className="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {getInitials(auth.user.name ?? auth.user.nombre_completo)}
                            </AvatarFallback>
                        </Avatar>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent
                        className="w-(--radix-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                        align="end"
                        side={isMobile ? 'bottom' : state === 'collapsed' ? 'left' : 'bottom'}
                    >
                        {/* <DropdownMenuItem asChild>
                            <Link href={route('')} prefetch>
                                <SidebarMenuButton className="flex items-center gap-2 rounded-lg px-4 py-2 text-sm text-sidebar-accent-foreground hover:bg-sidebar-accent">
                                    <Settings className="h-5 w-5 text-sidebar-accent-foreground" />
                                    <span>Configuración</span>
                                </SidebarMenuButton>
                            </Link>
                        </DropdownMenuItem> */}
                        <DropdownMenuItem asChild>
                            <Link href={'/the-owl/public/'} prefetch>
                                <SidebarMenuButton className="flex items-center gap-2 rounded-lg border-0 px-4 py-2 text-sm text-sidebar-accent-foreground hover:bg-sidebar-accent">
                                    <Store className="h-5 w-5 text-sidebar-accent-foreground" />
                                    <span>Ir a la página web</span>
                                </SidebarMenuButton>
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem asChild>
                            <Button onClick={logout} variant={'ghost'} className="w-full px-0">
                                <SidebarMenuButton className="flex items-center rounded-lg px-4 py-2 text-sm text-sidebar-accent-foreground hover:bg-sidebar-accent">
                                    <LogOut className="h-5 w-5 text-sidebar-accent-foreground" />
                                    <span>Cerrar sesión</span>
                                </SidebarMenuButton>
                            </Button>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </SidebarMenuItem>
        </SidebarMenu>
    );
}
