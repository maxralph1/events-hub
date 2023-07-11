import { useNavigate, useParams } from 'react-router-dom'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner' 
import { useCurrency } from '@/hooks/useCurrency'
 
function EditCurrency() {
    const params = useParams()
    const { currency, updateCurrency } = useCurrency(params.id)
    const navigate = useNavigate()
    
    async function handleSubmit(event) {
        event.preventDefault()
    
        await updateCurrency(currency.data)
    }
    
    return (
        <form onSubmit={ handleSubmit } noValidate>
            <div className="">
        
                <h1 className="">Edit Currency</h1>
        
                <div className="">
                <label htmlFor="title" className="required">Title</label>
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
                    <label htmlFor="description">Description</label>
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
        
                <div className="flex items-center gap-2">
                    <button
                        type="submit"
                        className=""
                        disabled={ currency.loading }
                    >
                        { currency.loading && <IconSpinner /> }
                        Update Currency
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
 
export default EditCurrency