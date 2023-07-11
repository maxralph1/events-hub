import { useNavigate } from 'react-router-dom'
import { useCurrency } from '@/hooks/useCurrency'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
 
function CreateCurrency() {
    const { currency, createCurrency } = useCurrency()
    const navigate = useNavigate()
    
    async function handleSubmit(event) {
        event.preventDefault()
    
        await createCurrency(currency.data)
    }
    
    return (
        <form onSubmit={ handleSubmit } noValidate>
        <div className="">
    
            <h1 className="">Add Currency</h1>
    
            <div className="">
            <label htmlFor="title" className="">Title</label>
            <input
                id="title"
                name="title"
                type="text"
                value={ currency.data.title ?? '' }
                onChange={ event => currency.setData({
                ...currency.data,
                title: event.target.value,
                }) }
                className=""
                disabled={ currency.loading }
            />
            <ValidationError errors={ currency.errors } field="title" />
            </div>
    
            <div className="">
            <label htmlFor="description" className="">Description</label>
            <input
                id="description"
                name="description"
                type="text"
                value={ currency.data.description ?? '' }
                onChange={ event => currency.setData({
                ...currency.data,
                description: event.target.value,
                }) }
                className=""
                disabled={ currency.loading }
            />
            <ValidationError errors={ currency.errors } field="description" />
            </div>
    
            <div className="border-t h-[1px] my-6"></div>
    
            <div className="">
            <button
                type="submit"
                className=""
                disabled={ currency.loading }
            >
                { currency.loading && <IconSpinner /> }
                Save Currency
            </button>
    
            <button
                type="button"
                className=""
                disabled={ currency.loading }
                onClick={ () => navigate(route('currencies.index')) }
            >
                <span>Cancel</span>
            </button>
            </div>
        </div>
        </form>
    )
}
 
export default CreateCurrency