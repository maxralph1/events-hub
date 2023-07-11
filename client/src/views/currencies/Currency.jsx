import { Link, useNavigate, useParams } from 'react-router-dom'
import { route } from '@/routes'
import { useCurrency } from '@/hooks/useCurrency'
// import { useAuth } from '@/hooks/useAuth'
 
function Currency() {
    const params = useParams()
    const { currency } = useCurrency(params.id)
    const navigate = useNavigate()
    // const { isAuthenticated, isSuperAdmin, isGenericUser, logout } = useAuth()
    
    return (
        <div className="">
    
            <h1 className="">Currency <b>{ currency.data.title }</b></h1>
            {/* {console.log(isAuthenticated)}
            {console.log(isSuperAdmin)}
            {console.log(isGenericUser)} */}

            <p>ID: { currency.data.id }</p>

            <p>Title: { currency.data.title }</p>
    
            <p>Description: { currency.data.description }</p>
    
            <div className=""></div>
    
            <div className="">
                <Link to={ route('currencies.index') } className="">
                    All Currencies
                </Link>
            </div>
        </div>
    )
}
 
export default Currency