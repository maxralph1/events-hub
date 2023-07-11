import { useNavigate, useParams } from 'react-router-dom'
import { route } from '@/routes'
import IconSpinner from '@/components/IconSpinner' 
import { useCountry } from '@/hooks/useCountry'
 
function Country() {
    const params = useParams()
    const { country } = useCountry(params.id)
    const navigate = useNavigate()
    
    return (
        <div className="">
    
            <h1 className="">Country <b>{ country.title }</b></h1>

            <p>Title: { country.title }</p>
    
            <p>Description: { country.description }</p>
    
            <div className="border-t h-[1px] my-6"></div>
    
            <div className="flex items-center gap-2">
                <button
                    type="button"
                    className=""
                    disabled={ country.loading }
                    onClick={ () => navigate(route('countries.index')) }
                >Countries
                </button>
            </div>
        </div>
    )
}
 
export default Country