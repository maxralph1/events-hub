import { Link } from 'react-router-dom'
import { route } from '@/routes'
import { useCountries } from '@/hooks/useCountries'
import { useCountry } from '@/hooks/useCountry'
 
function CountriesList() {
    const { countries, getCountries } = useCountries()
    const { destroyCountry } = useCountry()
    
    return (
        <div className="">
    
            <h1 className="">Countries</h1>
        
            <Link to={ route('countries.create') } className="">
                Add Country
            </Link>
        
            <div className="border-t h-[1px] my-6"></div>
        
            <div className="">
                { countries.length > 0 && countries.map(country => {
                return (
                    <div
                    key={ country.id }
                    className=""
                    >
                        <div className="">
                            <div className="">
                                { country.title }
                            </div>
                            <div className="">
                                { country.description }
                            </div>
                        </div>
                        <div className="flex gap-1">
                            <Link
                                to={ route('countries.edit', { id: country.id }) }
                                className=""
                            >
                            Edit
                            </Link>
                            <button
                                type="button"
                                className=""
                                onClick={ async () => {
                                    await destroyCountry(country)
                                    await getCountries()
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
 
export default CountriesList