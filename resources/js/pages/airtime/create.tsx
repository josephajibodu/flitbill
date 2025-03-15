import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { CreditCard, Receipt } from 'lucide-react';

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
    {
        name: 'MTN',
        logo: 'https://via.placeholder.com/150',
    },
    {
        name: 'Airtel',
        logo: 'https://via.placeholder.com/150',
    },
    {
        name: 'Glo',
        logo: 'https://via.placeholder.com/150',
    },
    {
        name: '9mobile',
        logo: 'https://via.placeholder.com/150',
    },
];

export default function BuyAirtime() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid h-full flex-1 grid-cols-1 flex-col gap-6 rounded-xl sm:grid-cols-2">
                    {/* Form */}
                    <Card className="neo-card-border">
                        <CardContent>
                            <h2 className="mb-4 text-base font-medium">Select Network Provider</h2>
                            <div className="flex flex-wrap gap-4">
                                {networks.map((network) => (
                                    <label className="neo-card group has-checked:bg-primary/10 has-checked:border-primary flex h-[100px] cursor-pointer flex-col items-center gap-2 rounded-lg bg-white p-4 has-checked:text-white sm:w-[100px]">
                                        <input type="radio" name="provider" className="hidden" />
                                        <div className="flex flex-col items-center">
                                            <div className="group-has-checked:bg-primary flex h-12 w-12 items-center justify-center rounded-full">
                                                <svg
                                                    className="h-6 w-6 group-has-checked:text-white"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <span className="text-app-black">{network.name}</span>
                                        </div>
                                    </label>
                                ))}
                            </div>

                            <div className="mt-6 grid w-full items-center gap-1.5">
                                <Label htmlFor="phone_number" className="text-base">
                                    Phone Number
                                </Label>
                                <Input type="tel" id="phone_number" placeholder="08012345678" />
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
                                <Input type="text" id="amount" placeholder="1000" />

                                <div className="flex gap-4 overflow-x-auto py-2">
                                    {[500, 1000, 2000, 5000, 10_000].map((amt, index) => (
                                        <Button
                                            key={index}
                                            variant="secondary"
                                            className="text-app-black neolift-effect hover:bg-primary h-10 w-[80px]"
                                        >
                                            +{amt}
                                        </Button>
                                    ))}
                                </div>
                            </div>

                            <div className="mt-6 flex items-center space-x-2">
                                <Checkbox id="terms" />
                                <label
                                    htmlFor="terms"
                                    className="text-base leading-none font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                >
                                    Add to beneficiary
                                </label>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="shadow-md">
                        <CardHeader>
                            <CardTitle>Order Summary</CardTitle>
                            <CardDescription>Review your purchase details</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                <div className="bg-muted/50 flex items-center gap-4 rounded-lg p-4">
                                    <div className="flex items-center gap-3">
                                        <div className="flex h-10 w-10 items-center justify-center rounded-full">
                                            <img
                                                src={'/placeholder.svg?height=30&width=30'}
                                                alt={'Network'}
                                                width={24}
                                                height={24}
                                                className="rounded-full"
                                            />
                                        </div>
                                        <div>
                                            <p className="font-medium">'Select Network</p>
                                            <p className="text-muted-foreground text-sm">No number selected</p>
                                        </div>
                                    </div>
                                    <div className="text-muted-foreground">Select a network provider</div>
                                </div>

                                <div className="space-y-3">
                                    <div className="flex justify-between">
                                        <span className="text-muted-foreground">Airtime Amount</span>
                                        <span className="font-medium">₦0</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span className="text-muted-foreground">Service Fee</span>
                                        <span className="font-medium">₦0</span>
                                    </div>
                                    <Separator />
                                    <div className="flex justify-between">
                                        <span className="font-medium">Total</span>
                                        <span className="font-bold">₦0</span>
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
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
