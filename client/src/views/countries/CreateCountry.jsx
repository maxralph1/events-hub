import { useNavigate } from 'react-router-dom'
import { useCountry } from '@/hooks/useCountry'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
 
function CreateCountry() {
    const { country, createCountry } = useCountry()
    const navigate = useNavigate()
    
    async function handleSubmit(event) {
        event.preventDefault()
    
        await createCountry(country.data)
    }
    
    return (
        <form onSubmit={ handleSubmit } noValidate>
        <div className="">
    
            <h1 className="">Add Country</h1>
    
            <div className="">
            <label htmlFor="title" className="">Title</label>
            <input
                id="title"
                name="title"
                type="text"
                value={ country.data.title ?? '' }
                onChange={ event => country.setData({
                ...country.data,
                title: event.target.value,
                }) }
                className=""
                disabled={ country.loading }
            />
            <ValidationError errors={ country.errors } field="title" />
            </div>
    
            <div className="">
            <label htmlFor="description" className="">Description</label>
            <input
                id="description"
                name="description"
                type="text"
                value={ country.data.description ?? '' }
                onChange={ event => country.setData({
                ...country.data,
                description: event.target.value,
                }) }
                className=""
                disabled={ country.loading }
            />
            <ValidationError errors={ country.errors } field="description" />
            </div>
    
            <div className="border-t h-[1px] my-6"></div>
    
            <div className="">
            <button
                type="submit"
                className=""
                disabled={ country.loading }
            >
                { country.loading && <IconSpinner /> }
                Save Country
            </button>
    
            <button
                type="button"
                className=""
                disabled={ country.loading }
                onClick={ () => navigate(route('countries.index')) }
            >
                <span>Cancel</span>
            </button>
            </div>
        </div>
        </form>
    )
}
 
export default CreateCountry