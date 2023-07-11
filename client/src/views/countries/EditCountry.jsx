import { useNavigate, useParams } from 'react-router-dom'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner' 
import { useCountry } from '@/hooks/useCountry'
 
function EditCountry() {
    const params = useParams()
    const { country, updateCountry } = useCountry(params.id)
    const navigate = useNavigate()
    
    async function handleSubmit(event) {
        event.preventDefault()
    
        await updateCountry(country.data)
    }
    
    return (
        <form onSubmit={ handleSubmit } noValidate>
            <div className="">
        
                <h1 className="">Edit Country</h1>
        
                <div className="">
                <label htmlFor="title" className="required">Title</label>
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
                    <label htmlFor="description">Description</label>
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
        
                <div className="flex items-center gap-2">
                    <button
                        type="submit"
                        className=""
                        disabled={ country.loading }
                    >
                        { country.loading && <IconSpinner /> }
                        Update Country
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
 
export default EditCountry