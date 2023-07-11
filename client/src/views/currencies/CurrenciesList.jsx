import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useCurrencies } from '@/hooks/useCurrencies'
import { useCurrency } from '@/hooks/useCurrency'
 
function CurrenciesList() {
    const { currencies, getCurrencies } = useCurrencies()
    const { destroyCurrency } = useCurrency()
    
    return (
        <div className="">
    
            <h1 className="">Currencies</h1>
        
            <Link to={ route('currencies.create') } className="">
                Add Currency
            </Link>
        
            <div className="border-t h-[1px] my-6"></div>
        
            <div className="">
                { currencies.length > 0 && currencies.map(currency => {
                return (
                    <div
                    key={ currency.id }
                    className=""
                    >
                        <div className="">
                            <div className="">
                                { currency.title }
                            </div>
                            <div className="">
                                { currency.description }
                            </div>
                        </div>
                        <div className="flex gap-1">
                            <Link
                                to={ route('currencies.show', { id: currency.id }) }
                                className=""
                            >
                            Show
                            </Link>
                            <Link
                                to={ route('currencies.edit', { id: currency.id }) }
                                className=""
                            >
                            Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyCurrency(currency)
                                    await getCurrencies()
                                } }
                            >
                            X
                            </button>
                        </div>
                    </div>
                )
                })}
            </div>
        </div>
    )
}
 
export default CurrenciesList