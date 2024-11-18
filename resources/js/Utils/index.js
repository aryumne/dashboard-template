export const APP_URL = import.meta.env.VITE_APP_URL;
export const APP_API_URL = import.meta.env.VITE_APP_URL + "/api";
export function GenerateAssetUrl(path, fromStorage = true) {
    if (path !== null) {
        return fromStorage
            ? APP_URL + "/storage/" + path
            : APP_URL + "/" + path;
    } else return "";
}

export function trimLongText(text, maxLength) {
    if (text.length <= maxLength) {
        return text;
    } else {
        return text.substring(0, maxLength) + "...";
    }
}

export function hasAccess(userPermissions, componentPermisions) {
    return componentPermisions.length > 0
        ? componentPermisions.some((up) => userPermissions.includes(up))
        : true;
}

export function getTypeByBoolean(isActive) {
    return isActive === true ? "info" : "error";
}

export function getTypeByObject(options, event) {
    return options[event];
}

export function getText(isActive) {
    return isActive === true ? "Yes" : "No";
}

export function sortSeasons(seasons) {
    return seasons.sort((a, b) => {
        // Compare numbers first
        const numA = parseInt(a.display_name.substring(2));
        const numB = parseInt(b.display_name.substring(2));

        if (numA !== numB) {
            return numA - numB;
        }

        // If numbers are the same, compare seasons
        const seasonOrder = { SP: 1, SU: 2, FA: 3, HO: 4 };
        const seasonA = a.display_name.substring(0, 2);
        const seasonB = b.display_name.substring(0, 2);
        return seasonOrder[seasonA] - seasonOrder[seasonB];
    });
}
