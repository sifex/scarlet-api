export function open_scarlet(
    token: string = '',
    protocol: string = 'scarlet',
): void {

    const scarlet_api_url = encodeURIComponent(window.location.origin + '/') + '#'
    const redirect_url = protocol + '://open?token=' + token + '&scarlet_api_url=' + scarlet_api_url
    console.log(redirect_url)
    window.location.href = redirect_url
}
