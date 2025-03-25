import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Drawer, DrawerContent, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/app-layout';
import { cn, toMoney } from '@/lib/utils';
import type { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { CreditCard, MessageCircleQuestionIcon, Receipt } from 'lucide-react';
import { useEffect, useState } from 'react';
import {Aside, MainScreen, ServicePurchaseLayout} from "@/layouts/service-purchase-layout";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Buy Data',
        href: route('data-topup.create'),
    },
];

const networks = [
    { name: 'MTN', logo: '/images/providers/mtn.svg', color: '#ffce27' },
    { name: 'Airtel', logo: '/images/providers/airtel.svg', color: '#ff1f1a' },
    { name: 'Glo', logo: '/images/providers/glo.svg', color: '#448141' },
    { name: '9mobile', logo: '/images/providers/9mobile.svg', color: '#1b765d' },
];

export default function BuyData() {
    const { data, setData } = useForm({
        network: '',
        phone_number: '',
        plan: '',
        amount: '',
    });

    const [isMobile, setIsMobile] = useState(false);

    useEffect(() => {
        const handleResize = () => setIsMobile(window.innerWidth < 640); // Adjust breakpoint as needed
        handleResize();
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <ServicePurchaseLayout>
                <MainScreen>
                    <h2 className="mb-4 text-base font-medium">Select Network Provider</h2>
                    <div className="grid grid-cols-4 gap-4">
                        {networks.map((network) => (
                            <label
                                className={cn(
                                    'neo-card-border neolift-effect-highlight group has-checked:neolift-effect flex h-14 cursor-pointer items-center justify-center gap-2 rounded-lg bg-white p-4 has-checked:text-white sm:w-[100px] md:h-[100px] md:justify-center',
                                    {
                                        'neo-active': data.network === network.name,
                                    },
                                )}
                                style={
                                    {
                                        '--highlight': network.color,
                                    } as React.CSSProperties
                                }
                            >
                                <div className="flex flex-col items-center">
                                    <img
                                        src={network.logo}
                                        alt={network.name}
                                        className={cn(
                                            'h-10 grayscale transition-all duration-200 group-hover:grayscale-0 group-has-checked:grayscale-0 md:h-14 md:min-w-20',
                                        )}
                                    />
                                    <span className="text-app-black sr-only">{network.name}</span>
                                </div>

                                <input
                                    type="radio"
                                    name="provider"
                                    className="checked:border-primary checked:ring-primary box-content hidden h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-white bg-clip-padding ring-1 ring-gray-950/20 outline-none"
                                    checked={data.network === network.name}
                                    onChange={() => setData('network', network.name)}
                                />
                            </label>
                        ))}
                    </div>

                    <div className="mt-6 grid w-full items-center gap-1.5">
                        <Label htmlFor="phone_number" className="text-base">
                            Phone Number
                        </Label>
                        <Input
                            type="tel"
                            id="phone_number"
                            placeholder="08012345678"
                            value={data.phone_number}
                            onChange={(e) => setData('phone_number', e.target.value)}
                        />
                    </div>

                    <div className="mt-8">
                        <Tabs defaultValue="Daily" className="h-full">
                            <TabsList className="flex w-full justify-start gap-1 overflow-x-auto rounded-md border bg-transparent px-1">
                                {['Daily', 'Weekly', 'Monthly', '6 Months', 'Yearly'].map((name) => (
                                    <TabsTrigger value={name} className="flex-grow-0 rounded-md">
                                        {name}
                                    </TabsTrigger>
                                ))}
                            </TabsList>

                            {['Daily', 'Weekly', 'Monthly', '6 Months', 'Yearly'].map((name) => (
                                <TabsContent value={name} className="flex-1">
                                    <div className="grid grid-cols-3 gap-4 md:grid-cols-4">
                                        {Array.from({ length: 10 }).map(() => (
                                            <div className="flex flex-col items-center gap-0.5 rounded-lg border bg-white py-2">
                                                <h3 className="font-bold">200MB</h3>
                                                <p className="text-sm">2 days</p>
                                                <p className="text-sm">N200</p>
                                                <p className="text-primary text-xs">N5 Cashback</p>
                                            </div>
                                        ))}
                                    </div>
                                </TabsContent>
                            ))}
                        </Tabs>
                    </div>
                </MainScreen>

                <Aside>
                    <div className="flex h-full flex-col space-y-4">
                        <div className="bg-primary/10 flex items-center gap-4 rounded-lg border p-4">
                            <div className="flex items-center gap-3">
                                <div className="flex w-20 items-center justify-center rounded-full">
                                    {data.network ? (
                                        <img
                                            src={networks.find((network) => network.name === data.network)?.logo}
                                            alt={data.network || 'Network'}
                                            className="h-10 min-w-10 md:h-14"
                                        />
                                    ) : (
                                        <MessageCircleQuestionIcon className="h-10 min-w-10 md:h-14" />
                                    )}
                                </div>
                                <div>
                                    <p className="font-medium">{data.network || 'Select Network'}</p>
                                    <p className="text-muted-foreground text-sm">{data.phone_number || 'No number selected'}</p>
                                </div>
                            </div>
                        </div>

                        <div className="space-y-3 rounded-lg border py-4">
                            <div className="flex justify-between px-4">
                                <span className="text-muted-foreground">Data Plan</span>
                                <span className="font-medium">{data.plan || '-'}</span>
                            </div>
                            <div className="flex justify-between px-4">
                                <span className="text-muted-foreground">Data Amount</span>
                                <span className="font-medium">{toMoney(Number(data.amount) || 0)}</span>
                            </div>
                            <div className="flex justify-between px-4">
                                <span className="text-muted-foreground">Service Fee</span>
                                <span className="font-medium">{toMoney(0)}</span>
                            </div>
                            <Separator />
                            <div className="flex justify-between px-4">
                                <span className="font-medium">Total</span>
                                <span className="font-bold">{toMoney(Number(data.amount))}</span>
                            </div>
                        </div>

                        <div className="space-y-3 pt-4">
                            <div className="flex items-center gap-2 text-sm">
                                <CreditCard className="text-muted-foreground h-4 w-4" />
                                <span>Secure payment processing</span>
                            </div>
                            <div className="flex items-center gap-2 text-sm">
                                <Receipt className="text-muted-foreground h-4 w-4" />
                                <span>Instant airtime delivery</span>
                            </div>
                        </div>

                        <div className="mt-auto">
                            <Button className="neolift-effect hover:bg-primary w-full">Proceed to Payment</Button>
                        </div>
                    </div>
                </Aside>
            </ServicePurchaseLayout>
        </AppLayout>
    );
}
