// MARKET
export const MARKET_TYPE = {
    INLINE: "INLINE",
    GEL: "GEL",
    ALL: "ALL",
};
export const MARKET_OPTIONS = [
    { label: "INLINE", value: "INLINE" },
    { label: "GEL", value: "GEL" },
];
export const STATUS_OPTIONS = {
    active: "info",
    inactive: "secondary",
    dropped: "error",
    shipped: "success",
};

// PROJECT & PRODUCT(BOM)
export const PROJECT_STATUSES = {
    ACTIVE: "active",
    INACTIVE: "inactive",
    DROPPED: "dropped",
};
export const PROJECT_STATUS_OPTIONS = Object.entries(PROJECT_STATUSES).map(
    ([key, value]) => ({
        id: value,
        display_name: value,
    })
);

// SAMPLE REQUEST (SR)
export const SR_TYPE = {
    COMMERCE: "COMMERCE",
    INTERNAL: "INTERNAL",
    OTHERS: "OTHERS",
    STAGE: "STAGE",
    PROMO: "PROMO",
};

export const SR_TYPE_OPTIONS = Object.entries(SR_TYPE)
    .filter(([key]) => key !== SR_TYPE.STAGE && key !== SR_TYPE.PROMO)
    .map(([key, value]) => ({
        label: value,
        value: value,
    }));

export const SR_STATUSES = {
    ACTIVE: "active",
    SHIPPED: "shipped",
    DROPPED: "dropped",
};
export const SR_STATUS_OPTIONS = Object.entries(SR_STATUSES).map(
    ([key, value]) => ({
        id: value,
        display_name: value,
    })
);
export const SAMPLE_FACTORIES = {
    IR: "IR",
    IR2: "IR2",
    JX: "JX",
    JX2: "JX2",
    PM: "PM",
};
export const SAMPLE_FACTORIES_ARRAY = Object.entries(SAMPLE_FACTORIES).map(
    ([key, value]) => ({
        id: value,
        display_name: value,
    })
);

// GENDER
export const GENDER = {
    MALE: "MALE",
    FEMALE: "FEMALE",
    UNISEX: "UNISEX",
    GS: "GRADE SCHOOL",
    PS: "PRE SCHOOL",
    TODDLER: "TODDLER",
};

// LOG ACTIVITY
export const ACTIVITY_EVENT_BADGES = {
    created: "info",
    updated: "warning",
    deleted: "error",
};
export const PRODUCT_UPLOAD_BADGES = {
    SUCCESS: "success",
    FAILED: "error",
};

// PURCHASE OREDER
export const ORDER_UNITS = [
    {
        id: "M",
        display_name: "M",
    },
    {
        id: "S/F",
        display_name: "S/F",
    },
    {
        id: "LY",
        display_name: "LY",
    },
    {
        id: "YD",
        display_name: "YD",
    },
    {
        id: "PRS",
        display_name: "PRS",
    },
    {
        id: "EA",
        display_name: "EA",
    },
    {
        id: "PCS",
        display_name: "PCS",
    },
    {
        id: "KG",
        display_name: "KG",
    },
    {
        id: "SHT",
        display_name: "SHT",
    },
    {
        id: "DRAM",
        display_name: "DRAM",
    },
    {
        id: "CONS",
        display_name: "CONS",
    },
    {
        id: "SQM",
        display_name: "SQM",
    },
    {
        id: "ROLL",
        display_name: "ROLL",
    },
    {
        id: "SET",
        display_name: "SET",
    },
    {
        id: "BOX",
        display_name: "BOX",
    },
];
