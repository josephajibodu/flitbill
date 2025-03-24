import {Button} from '@/components/ui/button';
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from '@/components/ui/card';
import {Drawer, DrawerContent, DrawerHeader, DrawerTitle, DrawerTrigger} from '@/components/ui/drawer';
import {useEffect, useState} from 'react';
import * as React from "react";
import {cn} from "@/lib/utils";

function MainScreen({ className, ...props }: React.ComponentProps<"div">) {
    return <Card className="rounded-none border-0 bg-transparent flex-1">
        <CardContent
            className={className}
            {...props}
        />
    </Card>;
}

function Aside({ className, ...props }: React.ComponentProps<"div">) {
    const [isMobile, setIsMobile] = useState(false);

    useEffect(() => {
        const handleResize = () => setIsMobile(window.innerWidth < 640); // Adjust breakpoint as needed
        handleResize();
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    return (
        <>
            {/* Order Summary */}
            {isMobile ? (
                <Drawer>
                    <div className="px-4 py-4">
                        <DrawerTrigger asChild>
                            <Button className="w-full">Continue</Button>
                        </DrawerTrigger>
                    </div>
                    <DrawerContent className="h-full px-4">
                        <DrawerHeader className="px-0">
                            <DrawerTitle className="">Order Summary</DrawerTitle>
                        </DrawerHeader>
                        <div
                            className={className}
                            {...props}
                        />
                    </DrawerContent>
                </Drawer>
            ) : (
                <Card className="rounded-none border-0 border-l shadow-md sm:border-l">
                    <CardHeader>
                        <CardTitle>Order Summary</CardTitle>
                        <CardDescription>Review your purchase details</CardDescription>
                    </CardHeader>
                    <CardContent className="h-full">
                        <div
                            className={className}
                            {...props}
                        />
                    </CardContent>
                </Card>
            )}
        </>
    );
}

function ServicePurchaseLayout({ className, ...props }: React.ComponentProps<"div">) {
    return (
        <div
            className={cn("flex flex-col h-full rounded-xl sm:grid grid-cols-1 sm:grid-cols-2", className)}
            {...props}
        />
    );
}

export {ServicePurchaseLayout, Aside, MainScreen }