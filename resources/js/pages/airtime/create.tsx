import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Drawer, DrawerContent, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/app-layout';
import { cn, toMoney } from '@/lib/utils';
import type { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { CreditCard, MessageCircleQuestionIcon, Receipt } from 'lucide-react';
import { useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Buy Airtime',
        href: route('airtime.create'),
    },
];

const networks = [
    { name: 'MTN', logo: '/images/providers/mtn.svg', color: '#ffce27' },
    { name: 'Airtel', logo: '/images/providers/airtel.svg', color: '#ff1f1a' },
    { name: 'Glo', logo: '/images/providers/glo.svg', color: '#448141' },
    { name: '9mobile', logo: '/images/providers/9mobile.svg', color: '#1b765d' },
];

export default function BuyAirtime() {
    const [isMobile, setIsMobile] = useState(false);

    const [formattedAmount, setFormattedAmount] = useState('');
    const { data, setData } = useForm({
        network: '',
        phone_number: '',
        amount: '',
    });

    const handleAmountChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        let input = e.target.value.replace(/[^\d.]/g, ''); // Remove invalid characters

        const parts = input.split('.');
        if (parts.length > 2) {
            input = parts[0] + '.' + parts.slice(1).join('');
        }

        // eslint-disable-next-line prefer-const
        let [integer, decimal] = input.split('.');
        integer = integer?.replace(/\B(?=(\d{3})+(?!\d))/g, ',') || '';

        const formattedValue = decimal !== undefined ? `${integer}.${decimal.slice(0, 2)}` : integer;

        setFormattedAmount(formattedValue);
        setData('amount', input); // Keep raw numeric value
    };

    useEffect(() => {
        const handleResize = () => setIsMobile(window.innerWidth < 640); // Adjust breakpoint as needed
        handleResize();
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    const OrderSummaryContent = (
        <div className="flex h-full flex-col space-y-4">
            <div className="bg-muted/50 flex items-center gap-4 rounded-lg p-4">
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

            <div className="space-y-3 border py-4">
                <div className="flex justify-between px-4">
                    <span className="text-muted-foreground">Airtime Amount</span>
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
    );

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl">
                <div className="grid h-full flex-1 grid-cols-1 flex-col rounded-xl sm:grid-cols-2">
                    {/* Form */}
                    <Card className="rounded-none border-0 bg-transparent">
                        <CardContent>
                            <h2 className="mb-4 text-base font-medium">Select Network Provider</h2>
                            <div className="grid grid-cols-4 gap-4">
                                {networks.map((network) => (
                                    <label
                                        className={cn(
                                            'neo-card-border neolift-effect-highlight group has-checked:neolift-effect flex h-14 cursor-pointer items-center justify-center gap-2 rounded-lg bg-white p-4 has-checked:text-white md:h-[100px] md:justify-center',
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

                            <div className="mt-6 grid w-full items-center gap-1.5">
                                <div className="flex items-center justify-between">
                                    <Label htmlFor="amount" className="text-base">
                                        Amount
                                    </Label>
                                    <span className="text-sm">
                                        Min: <span className="font-semibold">₦100</span> | Max: <span className="font-semibold">₦100,000</span>
                                    </span>
                                </div>
                                <Input type="text" id="amount" placeholder="₦0.00" value={formattedAmount} onChange={handleAmountChange} />

                                <div className="flex gap-4 overflow-x-auto py-2">
                                    {[500, 1000, 2000, 5000, 10_000].map((amt, index) => (
                                        <Button
                                            key={index}
                                            className="text-app-black neolift-effect hover:bg-primary h-8 w-[80px] border-none bg-gray-200 md:h-10"
                                            onClick={() => {
                                                const formatted = amt.toLocaleString();
                                                setFormattedAmount(formatted);
                                                setData('amount', amt.toString());
                                            }}
                                        >
                                            +{amt}
                                        </Button>
                                    ))}
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    {/* Order Summary */}
                    {isMobile ? (
                        <Drawer>
                            <DrawerTrigger asChild>
                                <Button className="w-full">Continue</Button>
                            </DrawerTrigger>
                            <DrawerContent className="h-full px-4">
                                <DrawerHeader className="px-0">
                                    <DrawerTitle className="">Order Summary</DrawerTitle>
                                </DrawerHeader>
                                {OrderSummaryContent}
                            </DrawerContent>
                        </Drawer>
                    ) : (
                        <Card className="rounded-none border-0 border-l shadow-md sm:border-l">
                            <CardHeader>
                                <CardTitle>Order Summary</CardTitle>
                                <CardDescription>Review your purchase details</CardDescription>
                            </CardHeader>
                            <CardContent className="h-full">{OrderSummaryContent}</CardContent>
                        </Card>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
