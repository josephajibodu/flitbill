import {ChangeEvent, useEffect, useState} from "react";
import {Check} from "lucide-react";
import {toMoney} from "@/lib/utils";
import {usePage} from "@inertiajs/react";
import {PageProps} from "@/types";

const wallets = ['main', 'bonus'];

export default function ({ amount, onChange } : {amount?: number, onChange: (value: string) => void}) {
    const { auth: { user } } = usePage<PageProps>().props;
    const [wallet, setWallet] = useState<"main_bonus" | "main" | "bonus">();
    const isBothWalletsSelected = wallet === 'main_bonus';

    const mainDeduction = Math.min(user.main_balance, amount || 0);
    const bonusDeduction = Math.max(0, (amount || 0) - user.main_balance);

    useEffect(() => {
        if (!amount) return;

        if (amount <= user.main_balance) {
            setWallet('main');
        } else if (amount <= user.bonus_balance) {
            setWallet('bonus');
        } else if (amount <= (user.main_balance + user.bonus_balance)) {
            setWallet('main_bonus')
        } else {
            setWallet(undefined);
        }
    }, [amount, user.main_balance, user.bonus_balance, wallet])

    const handleWalletChange = (e: ChangeEvent<HTMLInputElement>) =>  {
        setWallet(e.target.value as "main" | "bonus" | "main_bonus");
        onChange && onChange(e.target.value)
    }

    return <div>
        <div className="flex items-center rounded-lg border">
            {isBothWalletsSelected ? (
                <div className="flex items-center justify-between w-full px-4 py-4 bg-primary/10">
                    <div className="flex flex-col w-full gap-2">
                        <div className="flex gap-8">
                            <span className="capitalize">Main Wallet ({ toMoney(user.main_balance as number) })</span>
                            <span className="text-destructive">-{ toMoney(mainDeduction) }</span>
                        </div>
                        <div className="flex gap-8">
                            <span className="capitalize">Bonus Wallet ({ toMoney(user.bonus_balance as number) })</span>
                            <span className="text-destructive">-{ toMoney(bonusDeduction) }</span>
                        </div>
                    </div>
                    <Check className="text-green-500 me-4" />
                </div>
            ) : (
                wallets.map((walletType) => {
                    const walletBalance = user[`${walletType}_balance`] as number;
                    const isDisabled = walletBalance < (amount || 0);

                    return (
                        <label
                            className={`flex justify-between items-center w-full has-checked:bg-primary/10 cursor-pointer p-4 first:border-e first:border-app-black ${isDisabled ? 'opacity-50 cursor-not-allowed' : ''}`}>
                            <div className="flex flex-col">
                                <span className="capitalize">{walletType} Wallet</span>
                                <span>{toMoney(walletBalance)}</span>
                            </div>
                            <input
                                type="radio"
                                name="wallet"
                                value={walletType}
                                className="peer checked:border-primary checked:ring-primary box-content hidden h-1.5 w-1.5 appearance-none rounded-full border-[5px] border-white bg-white bg-clip-padding ring-1 ring-gray-950/20 outline-none"
                                checked={walletType === wallet}
                                onChange={handleWalletChange}
                                disabled={isDisabled}
                            />
                            <Check className="text-green-500 peer-checked:block hidden"/>
                        </label>
                    )
                })
            )}
        </div>
    </div>
}